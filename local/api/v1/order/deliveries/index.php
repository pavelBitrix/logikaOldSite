<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";
CModule::IncludeModule("sale");

use Bitrix\Sale\Delivery\Services\Table;
use Bitrix\Sale\Delivery\Services\Manager;

$dbDeliveries = Table::getList([
    'filter' => ['ACTIVE' => 'Y'],
    'select' => ['ID', 'NAME', 'DESCRIPTION', 'CONFIG']
]);

$deliveries = [];
while ($delivery = $dbDeliveries->fetch()) {
    // Извлекаем цену из конфигурации, если есть
    $price = isset($delivery['CONFIG']['MAIN']['PRICE']) ? $delivery['CONFIG']['MAIN']['PRICE'] : 0;

    $deliveries[] = [
        "id" => $delivery["ID"],
        "name" => $delivery["NAME"],
        "description" => $delivery["DESCRIPTION"],
        "price" => $price,
        "currency" => "RUB" // Указываем валюту вручную, если ее нет
    ];
}

echo json_encode(["status" => "success", "data" => $deliveries]);
?>
