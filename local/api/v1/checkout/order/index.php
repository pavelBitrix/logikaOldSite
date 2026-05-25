<?php
/**
 * POST /api/v1/checkout/order
 *
 * Body:
 * {
 *   "delivery_id": 1,
 *   "payment_id": 10,
 *   "items": [{ "product_id": 123, "name": "Товар", "quantity": 2, "price": 1500 }],
 *   "properties": { "NAME": "...", "PHONE": "...", "EMAIL": "...", "ADDRESS": "...", "COMMENT": "..." }
 * }
 */
require_once __DIR__ . '/../../_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    api_error('Метод не поддерживается', 405);
}

\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('catalog');
\Bitrix\Main\Loader::includeModule('currency');

$user = api_require_auth();
$userId = $user['id'];

$body = api_body();

$deliveryId = (int) ($body['delivery_id'] ?? 0);
$paymentId  = (int) ($body['payment_id']  ?? 0);
$items      = $body['items']      ?? [];
$props      = $body['properties'] ?? [];

if (empty($items) || !is_array($items)) {
    api_error('Список товаров пуст', 400);
}
if (!$deliveryId) api_error('Не указан способ доставки', 400);
if (!$paymentId)  api_error('Не указан способ оплаты',  400);

$currency = \Bitrix\Currency\CurrencyManager::getBaseCurrency();

// ── 1. Создаём корзину из тела запроса (не из серверной сессии) ────────────
// Это устраняет warning "Incorrect call to the save process" и order_total: 0
$basket = \Bitrix\Sale\Basket::create(SITE_ID);

foreach ($items as $item) {
    $productId = (int)($item['product_id'] ?? 0);
    $quantity  = max(1, (float)($item['quantity'] ?? 1));
    $price     = (float)($item['price'] ?? 0);
    $name      = (string)($item['name'] ?? 'Товар');

    if (!$productId) continue;

    $basketItem = $basket->createItem('Bitrix\Catalog\Product\Basket', $productId);
    $result = $basketItem->setFields([
        'NAME'                   => $name,
        'QUANTITY'               => $quantity,
        'PRICE'                  => $price,
        'BASE_PRICE'             => $price,
        'CURRENCY'               => $currency,
        'LID'                    => SITE_ID,
        'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
        'CAN_BUY'                => 'Y',
        'DELAY'                  => 'N',
        'WEIGHT'                 => 0,
    ]);

    if (!$result->isSuccess()) {
        api_error('Ошибка товара #' . $productId . ': ' . implode(', ', $result->getErrorMessages()), 400);
    }
}

if ($basket->isEmpty()) {
    api_error('Корзина пуста после обработки товаров', 400);
}

// ── 2. Создаём заказ ───────────────────────────────────────────────────────
$order = \Bitrix\Sale\Order::create(SITE_ID, $userId);
$order->setPersonTypeId(1);
$order->setField('CURRENCY', $currency);

// Привязываем корзину ДО создания отгрузки (обязательный порядок в D7)
$order->setBasket($basket);

// ── 3. Отгрузка (доставка) ────────────────────────────────────────────────
$deliveryService = \Bitrix\Sale\Delivery\Services\Manager::getObjectById($deliveryId);
if (!$deliveryService) {
    api_error('Способ доставки #' . $deliveryId . ' не найден', 400);
}

$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem($deliveryService);
$shipment->setField('CURRENCY', $currency);

// Привязываем все позиции корзины к отгрузке
$shipmentItemCollection = $shipment->getShipmentItemCollection();
foreach ($basket as $basketItem) {
    $shipmentItem = $shipmentItemCollection->createItem($basketItem);
    $shipmentItem->setQuantity($basketItem->getQuantity());
}

// ── 4. Оплата ─────────────────────────────────────────────────────────────
$paySystemObject = \Bitrix\Sale\PaySystem\Manager::getObjectById($paymentId);
if (!$paySystemObject) {
    api_error('Способ оплаты #' . $paymentId . ' не найден', 400);
}

$paymentCollection = $order->getPaymentCollection();
$payment = $paymentCollection->createItem($paySystemObject);

// ── 5. Свойства заказа ────────────────────────────────────────────────────
$propertyCollection = $order->getPropertyCollection();

// Стандартные коды свойств Bitrix → ключи из props
$propMap = [
    'NAME'    => 'NAME',
    'PHONE'   => 'PHONE',
    'EMAIL'   => 'EMAIL',
    'ADDRESS' => 'ADDRESS',
];
foreach ($propMap as $bitrixCode => $jsonKey) {
    if (!isset($props[$jsonKey])) continue;
    $prop = $propertyCollection->getItemByOrderPropertyCode($bitrixCode);
    if ($prop) {
        $prop->setValue(htmlspecialchars(trim($props[$jsonKey])));
    }
}

// Комментарий → поле заказа (не свойство)
if (!empty($props['COMMENT'])) {
    $order->setField('USER_DESCRIPTION', htmlspecialchars(trim($props['COMMENT'])));
}

// ── 6. Пересчёт и установка суммы оплаты ─────────────────────────────────
$refreshResult = $order->refreshData();
if (!$refreshResult->isSuccess()) {
    api_error('Ошибка пересчёта заказа: ' . implode(', ', $refreshResult->getErrorMessages()), 500);
}

$totalPrice = $order->getPrice();
$payment->setField('SUM', $totalPrice);
$payment->setField('CURRENCY', $currency);

// ── 7. Сохранение ─────────────────────────────────────────────────────────
$saveResult = $order->save();

if (!$saveResult->isSuccess()) {
    api_error(
        'Ошибка сохранения заказа: ' . implode(', ', $saveResult->getErrorMessages()),
        500
    );
}

api_response([
    'success' => true,
    'data' => [
        'order_id'    => $order->getId(),
        'order_total' => $totalPrice,
        'status'      => $order->getField('STATUS_ID'),
    ],
], 201);
