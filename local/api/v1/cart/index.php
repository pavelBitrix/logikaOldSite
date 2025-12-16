<?php
// ini_set('session.cookie_samesite', 'None');
// ini_set('session.cookie_secure', '1'); // Только если у тебя HTTPS, иначе временно можешь поставить 0 для тестов
// session_start(); 
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

use Bitrix\Sale;
use Bitrix\Main\Context;

if (!CModule::IncludeModule("sale")) {
    echo json_encode(["status" => "error", "message" => "Не удалось подключить модуль Sale"]);
    die();
}

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Context::getCurrent()->getSite());

$totalQuantity = 0;

foreach ($basket as $basketItem) {
    $totalQuantity += $basketItem->getQuantity();
}

echo json_encode(["status" => "success", "totalQuantity" => $totalQuantity, "fuserID" => Sale\Fuser::getId()]);
?>
