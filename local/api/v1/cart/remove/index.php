<?php
// Подключаем Bitrix
// session_start(); 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

if (!CModule::IncludeModule("sale")) {
    echo json_encode(['status' => 'error', 'message' => 'Модуль Sale не найден']);
    exit;
}

// Получаем данные из запроса
$productId = $_POST['product_id'];


// Получаем ID пользователя из сессии
// $userId = $USER->GetID();
// echo json_encode(['userId' => $userId]);
if (!$productId) {
    echo json_encode(['status' => 'error', 'message' => 'Неверный запрос']);
    exit;
}

// Удаляем товар из корзины
$basketItem = CSaleBasket::GetList(
    array("ID" => "ASC"), 
    array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "PRODUCT_ID" => $productId, "ORDER_ID" => "NULL")
)->Fetch();

if ($basketItem) {
    CSaleBasket::Delete($basketItem["ID"]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Товар не найден в корзине']);
    exit;
}

// После удаления товара, подсчитываем общее количество уникальных товаров в корзине
$basketItems = CSaleBasket::GetList(
    array("ID" => "ASC"), 
    array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL")
);

$totalItems = 0;  // Считаем уникальные товары
$productsInCart = [];

while ($item = $basketItems->Fetch()) {
    // Добавляем только уникальные товары
    if (!in_array($item["PRODUCT_ID"], $productsInCart)) {
        $productsInCart[] = $item["PRODUCT_ID"];
        $totalItems++;
    }
}

// Отправляем единственный ответ с результатом
echo json_encode([
    'status' => 'success',
    'message' => 'Товар удален из корзины',
    'total_items' => $totalItems // Общее количество уникальных товаров в корзине
]);
?>
