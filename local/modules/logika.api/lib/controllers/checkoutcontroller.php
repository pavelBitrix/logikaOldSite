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
        Loader::includeModule('currency');

        $deliveryId = (int) ($body['delivery_id'] ?? 0);
        $paymentId  = (int) ($body['payment_id']  ?? 0);
        $properties = $body['properties'] ?? [];
        $bodyItems  = $body['items']      ?? [];

        if (!$deliveryId || !$paymentId) {
            Response::error('delivery_id и payment_id обязательны', 422);
        }

        $userId   = UserAuth::id();
        $currency = \Bitrix\Currency\CurrencyManager::getBaseCurrency();

        // Пробуем взять корзину из сессии Bitrix
        $basket = Basket::loadItemsForFUser(Fuser::getId(true), SITE_ID);

        // Если корзина пуста, но фронт передал товары — строим корзину из тела запроса
        if ($basket->isEmpty() && !empty($bodyItems)) {
            $basket = Basket::create(SITE_ID);
            foreach ($bodyItems as $item) {
                $productId = (int)($item['product_id'] ?? 0);
                if (!$productId) continue;

                $basketItem = $basket->createItem('catalog', $productId);
                $res = $basketItem->setFields([
                    'NAME'                   => (string)($item['name'] ?? 'Товар'),
                    'QUANTITY'               => max(1, (float)($item['quantity'] ?? 1)),
                    'PRICE'                  => (float)($item['price'] ?? 0),
                    'BASE_PRICE'             => (float)($item['price'] ?? 0),
                    'CURRENCY'               => $currency,
                    'LID'                    => SITE_ID,
                    'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                    'CAN_BUY'                => 'Y',
                    'DELAY'                  => 'N',
                    'WEIGHT'                 => 0,
                ]);
                if (!$res->isSuccess()) {
                    Response::error('Ошибка товара #' . $productId . ': ' . implode(', ', $res->getErrorMessages()), 422);
                }
            }
        }

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
        if (!$deliveryService) {
            Response::error('Способ доставки не найден', 422);
        }
        $shipment = $shipmentCollection->createItem($deliveryService);
        $shipment->setField('CURRENCY', $currency);

        foreach ($basket as $basketItem) {
            $shipmentItem = $shipment->getShipmentItemCollection()->createItem($basketItem);
            $shipmentItem->setQuantity($basketItem->getQuantity());
        }

        // ─── Оплата ─────────────────────────────────────────────────────────────
        $paymentCollection = $order->getPaymentCollection();
        $paySystem = PaySystem\Manager::getObjectById($paymentId);
        if (!$paySystem) {
            Response::error('Способ оплаты не найден', 422);
        }
        $payment = $paymentCollection->createItem($paySystem);

        // Пересчёт ПОСЛЕ привязки корзины и доставки, ДО установки суммы оплаты
        $order->refreshData();
        $payment->setField('SUM', $order->getPrice());
        $payment->setField('CURRENCY', $currency);

        // ─── Комментарий покупателя — поле заказа, а не свойство ───────────────
        // В Bitrix Sale комментарий хранится в ORDER.USER_DESCRIPTION, а не в коллекции свойств.
        // Если передавать через $propertyCollection без настроенного свойства COMMENT — молча игнорируется.
        if (!empty($properties['COMMENT'])) {
            $order->setField('USER_DESCRIPTION', (string) $properties['COMMENT']);
        }

        // ─── Свойства заказа (контактная информация) ────────────────────────────
        $propertyCollection = $order->getPropertyCollection();
        foreach ($properties as $code => $value) {
            if (strtoupper($code) === 'COMMENT') continue; // уже записан выше
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

        $orderId    = $order->getId();
        $orderTotal = (float) $order->getPrice();

        // ─── Инициация оплаты ───────────────────────────────────────────────────
        $paymentUrl  = null;
        $paymentHtml = null;

        $psService = PaySystem\Manager::getObjectById($payment->getPaymentSystemId());
        if ($psService) {
            $buffered   = '';
            $initResult = null;
            ob_start();
            try {
                $initResult = $psService->initiatePay(
                    $payment,
                    \Bitrix\Main\Application::getInstance()->getContext()->getRequest()
                );
            } catch (\Throwable $e) {
                // некоторые обработчики бросают вместо возврата ServiceResult
            } finally {
                $buffered = (string) ob_get_clean();
            }

            // Приоритет 1: HTML-форма, напечатанная в буфер вывода
            if ($buffered !== '' && stripos($buffered, '<form') !== false) {
                $paymentHtml = $buffered;
            } elseif ($initResult instanceof PaySystem\ServiceResult && $initResult->isSuccess()) {
                // Приоритет 2: стандартные методы ServiceResult
                $url  = method_exists($initResult, 'getPaymentUrl') ? $initResult->getPaymentUrl() : null;
                $html = method_exists($initResult, 'getTemplate')   ? $initResult->getTemplate()   : null;
                $data = method_exists($initResult, 'getData')       ? (array) $initResult->getData() : [];

                if ($url)                            $paymentUrl  = $url;
                elseif ($html)                       $paymentHtml = $html;
                elseif (!empty($data['PAYMENT_URL'])) $paymentUrl  = $data['PAYMENT_URL'];
                elseif (!empty($data['TEMPLATE']))    $paymentHtml = $data['TEMPLATE'];
            }
        }

        Response::success([
            'order_id'     => $orderId,
            'order_total'  => $orderTotal,
            'status'       => $order->getField('STATUS_ID'),
            'payment_url'  => $paymentUrl,
            'payment_html' => $paymentHtml,
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
