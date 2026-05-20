<?php
namespace Logika\Api\Controllers;

use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Delivery;
use Bitrix\Sale\Fuser;
use Bitrix\Sale\Order;
use Bitrix\Sale\PaySystem;
use Logika\Api\Auth\UserAuth;
use Logika\Api\Response;

class CheckoutController
{
    /**
     * GET checkout/info — доставки, оплаты и свойства заказа за один запрос
     */
    public function info(array $params, array $body): void
    {
        Loader::includeModule('sale');

        Response::success([
            'delivery_methods' => $this->getDeliveries(),
            'payment_methods'  => $this->getPayments(),
            'order_properties' => $this->getOrderProperties(),
        ]);
    }

    /**
     * POST checkout/calculate
     * Body: { delivery_id, items?: [{ product_id, quantity }] }
     * Возвращает стоимость доставки
     */
    public function calculate(array $params, array $body): void
    {
        Loader::includeModule('sale');
        Loader::includeModule('catalog');

        $deliveryId = (int) ($body['delivery_id'] ?? 0);
        if (!$deliveryId) {
            Response::error('delivery_id обязателен', 422);
        }

        $basket = Basket::loadItemsForFUser(Fuser::getId(true), SITE_ID);
        if ($basket->isEmpty()) {
            Response::error('Корзина пуста', 422);
        }

        $order = Order::create(SITE_ID, UserAuth::id() ?: null);
        $order->setPersonTypeId(1);
        $order->setBasket($basket);

        $shipmentCollection = $order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem(
            Delivery\Services\Manager::getObjectById($deliveryId)
        );
        $shipment->setField('CURRENCY', 'RUB');

        $calcResult = $shipment->calculateDelivery();
        $price = $calcResult->isSuccess() ? $calcResult->getPrice() : null;

        Response::success([
            'delivery_id'    => $deliveryId,
            'delivery_price' => $price,
            'basket_total'   => (float) $basket->getPrice(),
            'order_total'    => $price !== null ? (float) $basket->getPrice() + $price : null,
        ]);
    }

    /**
     * POST checkout/order
     * Body: {
     *   delivery_id,
     *   payment_id,
     *   properties: { NAME, PHONE, EMAIL, ADDRESS, COMMENT, ... }
     * }
     */
    public function createOrder(array $params, array $body): void
    {
        Loader::includeModule('sale');
        Loader::includeModule('catalog');

        $deliveryId = (int) ($body['delivery_id'] ?? 0);
        $paymentId  = (int) ($body['payment_id']  ?? 0);
        $properties = $body['properties'] ?? [];

        if (!$deliveryId || !$paymentId) {
            Response::error('delivery_id и payment_id обязательны', 422);
        }

        $userId = UserAuth::id(); // 0 = гость
        $basket = Basket::loadItemsForFUser(Fuser::getId(true), SITE_ID);

        if ($basket->isEmpty()) {
            Response::error('Корзина пуста', 422);
        }

        // ─── Создаём заказ ──────────────────────────────────────────────────────
        $order = Order::create(SITE_ID, $userId ?: null);
        $order->setPersonTypeId(1);
        $order->setBasket($basket);

        // ─── Доставка ───────────────────────────────────────────────────────────
        $shipmentCollection = $order->getShipmentCollection();
        $deliveryService    = Delivery\Services\Manager::getObjectById($deliveryId);
        $shipment = $shipmentCollection->createItem($deliveryService);
        $shipment->setField('CURRENCY', 'RUB');

        // ─── Оплата ─────────────────────────────────────────────────────────────
        $paymentCollection = $order->getPaymentCollection();
        $paySystem = PaySystem\Manager::getObjectById($paymentId);
        $payment = $paymentCollection->createItem($paySystem);
        $payment->setField('SUM', $order->getPrice());
        $payment->setField('CURRENCY', 'RUB');

        // ─── Свойства заказа (контактная информация) ────────────────────────────
        $propertyCollection = $order->getPropertyCollection();
        foreach ($properties as $code => $value) {
            $prop = $propertyCollection->getItemByOrderPropertyCode(strtoupper($code));
            if ($prop) {
                $prop->setValue($value);
            }
        }

        // ─── Сохраняем ──────────────────────────────────────────────────────────
        $result = $order->save();

        if (!$result->isSuccess()) {
            Response::error(implode('; ', $result->getErrorMessages()), 500);
        }

        $orderId = $order->getId();

        // Очищаем корзину после успешного оформления
        $basket->clearCollection();
        $basket->save();

        Response::success([
            'order_id'    => $orderId,
            'order_total' => (float) $order->getPrice(),
            'status'      => $order->getField('STATUS_ID'),
        ], 201);
    }

    // ─── Справочники ───────────────────────────────────────────────────────────

    private function getDeliveries(): array
    {
        $services = Delivery\Services\Manager::getActiveList();
        $result   = [];
        foreach ($services as $service) {
            $result[] = [
                'id'          => (int) $service['ID'],
                'name'        => $service['NAME'],
                'description' => $service['DESCRIPTION'] ?? '',
                'logo'        => $service['LOGOTIP'] ? \CFile::GetPath($service['LOGOTIP']) : null,
            ];
        }
        return $result;
    }

    private function getPayments(): array
    {
        $systems = PaySystem\Manager::getList(['select' => ['ID', 'NAME', 'DESCRIPTION', 'LOGOTIP', 'ACTIVE']])
            ->fetchAll();

        return array_values(array_map(fn($s) => [
            'id'          => (int) $s['ID'],
            'name'        => $s['NAME'],
            'description' => $s['DESCRIPTION'] ?? '',
            'logo'        => $s['LOGOTIP'] ? \CFile::GetPath($s['LOGOTIP']) : null,
        ], array_filter($systems, fn($s) => $s['ACTIVE'] === 'Y')));
    }

    private function getOrderProperties(): array
    {
        Loader::includeModule('sale');
        $res    = \CSaleOrderProps::GetList(['SORT' => 'ASC'], ['PERSON_TYPE_ID' => 1, 'ACTIVE' => 'Y']);
        $props  = [];
        while ($row = $res->Fetch()) {
            $props[] = [
                'id'       => (int) $row['ID'],
                'code'     => $row['CODE'],
                'name'     => $row['NAME'],
                'type'     => $row['TYPE'],        // TEXT, TEXTAREA, CHECKBOX, RADIO, SELECT, EMAIL, PHONE
                'required' => $row['REQUIRED'] === 'Y',
                'default'  => $row['DEFAULT_VALUE'] ?? null,
            ];
        }
        return $props;
    }
}
