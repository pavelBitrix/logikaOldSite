<?php 
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$allowed_origin = 'http://192.168.88.120:5173'; // Ваш фронтенд

// Устанавливаем заголовок ответа
header('Access-Control-Allow-Origin: ' . $allowed_origin);
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With'); // Добавлен X-Requested-With, иногда нужен
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Sale\Order;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Delivery\Services\Manager as DeliveryManager;
use Bitrix\Sale\PaySystem\Manager as PaySystemManager;

Loader::includeModule("sale");

global $USER;

// Получаем ID пользователя
$userId = $USER->GetID();
if (!$userId) {
    echo json_encode(['status' => 'error', 'message' => 'Пользователь не авторизован']);
    exit;
}

// Получаем данные из JSON-запроса
$request = Context::getCurrent()->getRequest();
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Некорректные данные заказа',
        'json_error' => json_last_error_msg()
    ]);
    exit;
}

// Загружаем корзину пользователя
$basket = Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), SITE_ID);

// Проверяем, пуста ли корзина
if ($basket->isEmpty()) {
    echo json_encode(['status' => 'error', 'message' => 'Корзина пуста']);
    exit;
}

// Вычисляем сумму заказа
$totalPrice = 0;
foreach ($basket as $basketItem) {
    $totalPrice += $basketItem->getFinalPrice();
}

// Создаем заказ
$order = Order::create(SITE_ID, $userId);
$order->setPersonTypeId(1);
$order->setBasket($basket);
$order->setField("PRICE", $totalPrice);
$order->setField("CURRENCY", CurrencyManager::getBaseCurrency());

// Добавляем доставку, если указана
if (!empty($data['deliveryMethod'])) {
    $shipmentCollection = $order->getShipmentCollection();
    $shipment = $shipmentCollection->createItem(DeliveryManager::getObjectById(intval($data['deliveryMethod'])));
    $shipmentItemCollection = $shipment->getShipmentItemCollection();

    foreach ($basket as $basketItem) {
        $shipmentItem = $shipmentItemCollection->createItem($basketItem);
        $shipmentItem->setQuantity($basketItem->getQuantity());
    }
}

// Добавляем оплату, если указана
if (!empty($data['paymentMethod'])) {
    $paymentCollection = $order->getPaymentCollection();
    $payment = $paymentCollection->createItem(PaySystemManager::getObjectById(intval($data['paymentMethod'])));
    $payment->setField("SUM", $totalPrice);
    $payment->setField("CURRENCY", $order->getCurrency());
}

// Устанавливаем свойства заказа (имя, email, телефон, комментарий)
$propertyCollection = $order->getPropertyCollection();
$fieldsMap = [
    "FIO" => "name",
    "EMAIL" => "email",
    "PHONE" => "phone",
    "ADDRESS" => "address",
    "ZIP" => "zip"
];

foreach ($fieldsMap as $bitrixCode => $jsonKey) {
    if (!empty($data[$jsonKey])) {
        $property = $propertyCollection->getItemByOrderPropertyCode($bitrixCode);
        if ($property) {
            $property->setValue(htmlspecialchars(trim($data[$jsonKey])));
        }
    }
}

// Добавляем комментарий к заказу
if (!empty($data['comment'])) {
    $order->setField("USER_DESCRIPTION", htmlspecialchars(trim($data['comment'])));
}

// Устанавливаем дополнительные параметры, если переданы
$extraFields = [
    "STATUS_ID" => "status",
    "PAYED" => "paid",
    "MARKED" => "marked",
    "RESPONSIBLE_ID" => "responsible",
    "DELIVERY_DOC_NUM" => "delivery_doc_num",
    "DELIVERY_DOC_DATE" => "delivery_doc_date",
    "TRACKING_NUMBER" => "tracking_number",
    "COMMENTS" => "internal_comment",
    "XML_ID" => "xml_id",
    "ACCOUNT_NUMBER" => "account_number"
];

foreach ($extraFields as $bitrixField => $jsonKey) {
    if (!empty($data[$jsonKey])) {
        $order->setField($bitrixField, htmlspecialchars(trim($data[$jsonKey])));
    }
}

// Сохраняем заказ
$result = $order->save();
if (!$result->isSuccess()) {
    echo json_encode(['status' => 'error', 'message' => $result->getErrorMessages()]);
} else {
    echo json_encode([
        'status' => 'success',
        'message' => 'Заказ успешно оформлен',
        'order_id' => $order->getId(),
        'total_price' => $totalPrice
    ]);
}