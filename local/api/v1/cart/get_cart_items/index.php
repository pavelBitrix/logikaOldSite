<?php

// ✅ Установим параметры сессии ДО подключения Bitrix:
ini_set('session.cookie_samesite', 'None');
ini_set('session.cookie_secure', '1'); // Только если у тебя HTTPS, иначе временно можешь поставить 0 для тестов
// Подключаем Bitrix
// session_start(); 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

// Устанавливаем заголовок ответа как JSON
header('Content-Type: application/json');

if (!CModule::IncludeModule("sale") || !CModule::IncludeModule("catalog") || !CModule::IncludeModule("iblock")) {
    echo json_encode(['status' => 'error', 'message' => 'Необходимые модули не найдены']);
    exit;
}


// Получаем FUSER_ID для текущего пользователя
$fuserId = CSaleBasket::GetBasketUserID();

if (!$fuserId) {
    echo json_encode(['status' => 'error', 'message' => 'Корзина не найдена']);
    exit;
}

// Получаем товары из корзины
$basket = CSaleBasket::GetList(
    array("ID" => "ASC"), 
    array("FUSER_ID" => $fuserId, "LID" => SITE_ID, "ORDER_ID" => "NULL"),
    false,
    false,
    array("ID", "PRODUCT_ID", "NAME", "PRICE", "CURRENCY", "QUANTITY", "DETAIL_PAGE_URL") 
);

$items = [];
$itemCount = 0;

while ($item = $basket->Fetch()) {
    $productId = $item['PRODUCT_ID'];
    $stockQuantity = 0; // Инициализируем остаток

    // --- Получаем информацию об остатках товара ---
    $productCatalogInfo = CCatalogProduct::GetByID($productId);
    if ($productCatalogInfo) {
        // QUANTITY содержит общий остаток на складах
        // Для доступного количества часто лучше использовать AVAILABLE_QUANTITY, если он есть,
        // или вычитать резерв: QUANTITY - QUANTITY_RESERVED
        // Для простоты пока возьмем общий остаток QUANTITY
        $stockQuantity = (int)$productCatalogInfo['QUANTITY'];
    }

    // Получаем детальное и превью изображение
    $productRes = CIBlockElement::GetByID($productId);
    if ($product = $productRes->GetNext()) {
        $detailPicture = CFile::GetPath($product['DETAIL_PICTURE']);
        $previewPicture = CFile::GetPath($product['PREVIEW_PICTURE']);

        // Получаем дополнительные изображения из свойства "MORE_PHOTO"
        $morePhotos = [];
        $propertyPhotos = CIBlockElement::GetProperty($product["IBLOCK_ID"], $productId, [], ["CODE" => "MORE_PHOTO"]);
        while ($photo = $propertyPhotos->Fetch()) {
            if ($photo["VALUE"]) {
                $morePhotos[] = CFile::GetPath($photo["VALUE"]);
            }
        }
    }

    // Определяем изображение по приоритету:
    // 1. Детальное изображение
    // 2. Превью изображение
    // 3. Первое изображение из MORE_PHOTO
    $mainImage = $detailPicture ?: $previewPicture ?: ($morePhotos[0] ?? null);

    $items[] = [
        'ID' => $item['ID'],
        'PRODUCT_ID' => $productId,
        'NAME' => $item['NAME'],
        'PRICE' => $item['PRICE'],
        'QUANTITY' => $item['QUANTITY'],
        'STOCK_QUANTITY' => $stockQuantity, // <<<--- ДОБАВЛЕНО: Остаток на складе
        'MAIN_IMAGE' => $mainImage, // Главное изображение товара
        'DETAIL_PICTURE' => $detailPicture, // Детальное фото
        'PREVIEW_PICTURE' => $previewPicture, // Превью фото
        'MORE_PHOTOS' => $morePhotos // Массив дополнительных изображений
    ];

    // Увеличиваем счетчик товаров в корзине
    $itemCount += $item['QUANTITY'];
}

echo json_encode([
    'status' => 'success',
    'items' => $items,
    'user_id' => $USER->GetID(),
    'fuser_id' => $fuserId,
    'total_items' => $itemCount
]);
?>
