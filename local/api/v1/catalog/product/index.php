<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

if (!CModule::IncludeModule("catalog") || !CModule::IncludeModule("iblock")) {
    echo json_encode(['status' => 'error', 'message' => 'Необходимые модули не найдены']);
    exit;
}

$productId = intval($_GET['id']);

if (!$productId) {
    echo json_encode(['status' => 'error', 'message' => 'Некорректный ID товара']);
    exit;
}

// Получаем товар
$productRes = CIBlockElement::GetByID($productId);
if (!$product = $productRes->GetNext()) {
    echo json_encode(['status' => 'error', 'message' => 'Товар не найден']);
    exit;
}

// Получаем изображения
$detailPicture = CFile::GetPath($product['DETAIL_PICTURE']);
$previewPicture = CFile::GetPath($product['PREVIEW_PICTURE']);

$morePhotos = [];
$propertyPhotos = CIBlockElement::GetProperty($product["IBLOCK_ID"], $productId, [], ["CODE" => "MORE_PHOTO"]);
while ($photo = $propertyPhotos->Fetch()) {
    if ($photo["VALUE"]) {
        $morePhotos[] = CFile::GetPath($photo["VALUE"]);
    }
}

// Получаем свойства товара
$properties = [];
$resProperties = CIBlockElement::GetProperty($product["IBLOCK_ID"], $productId, [], []);
while ($prop = $resProperties->Fetch()) {
    if ($prop["VALUE"]) {
        $properties[$prop["NAME"]] = is_array($prop["VALUE"]) ? implode(", ", $prop["VALUE"]) : $prop["VALUE"];
    }
}

// Получаем цену и количество
$price = CCatalogProduct::GetOptimalPrice($productId);
$quantity = CCatalogProduct::GetByID($productId)['QUANTITY'];


http_response_code(200);
echo json_encode([
    'status' => 'success',
    'product' => [
        'ID' => $productId,
        'NAME' => $product['NAME'],
        'PRICE' => $price['RESULT_PRICE']['DISCOUNT_PRICE'],
        'QUANTITY' => $quantity,
        'DETAIL_PICTURE' => $detailPicture,
        'PREVIEW_PICTURE' => $previewPicture,
        'MORE_PHOTOS' => $morePhotos,
        'PROPERTIES' => $properties,
        'DESCRIPTION' => $product['DETAIL_TEXT']
    ]
]);
?>