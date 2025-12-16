<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("sale");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

$dbPayments = \Bitrix\Sale\PaySystem\Manager::getList([
    'filter' => ['ACTIVE' => 'Y'],
    'select' => ['ID', 'NAME', 'DESCRIPTION']
]);

$payments = [];
while ($payment = $dbPayments->fetch()) {
    $payments[] = [
        "id" => $payment["ID"],
        "name" => $payment["NAME"],
        "description" => $payment["DESCRIPTION"]
    ];
}

echo json_encode(["status" => "success", "data" => $payments]);
?>
