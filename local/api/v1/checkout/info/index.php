<?php
/**
 * GET /api/v1/checkout/info
 * Возвращает список методов доставки и оплаты для страницы оформления заказа.
 * Авторизация не требуется.
 */
require_once __DIR__ . '/../../_bootstrap.php';

\Bitrix\Main\Loader::includeModule('sale');

// ── Методы доставки ────────────────────────────────────────────────────────
$dbDeliveries = \Bitrix\Sale\Delivery\Services\Table::getList([
    'filter' => ['ACTIVE' => 'Y', '!PARENT_ID' => false],
    'select' => ['ID', 'NAME', 'DESCRIPTION', 'LOGOTIP'],
    'order'  => ['SORT' => 'ASC', 'NAME' => 'ASC'],
]);

$deliveries = [];
$seenDeliveryNames = [];

while ($row = $dbDeliveries->fetch()) {
    $name = trim($row['NAME']);

    // Дедупликация: оставляем первый вариант каждого уникального названия
    if (isset($seenDeliveryNames[$name])) continue;
    $seenDeliveryNames[$name] = true;

    $logo = null;
    if (!empty($row['LOGOTIP'])) {
        $file = \CFile::GetFileArray($row['LOGOTIP']);
        if ($file) $logo = $file['SRC'];
    }

    $deliveries[] = [
        'id'          => (int) $row['ID'],
        'name'        => $name,
        'description' => trim($row['DESCRIPTION'] ?? ''),
        'logo'        => $logo,
    ];
}

// ── Методы оплаты ──────────────────────────────────────────────────────────
$dbPayments = \Bitrix\Sale\PaySystem\Manager::getList([
    'filter' => ['ACTIVE' => 'Y'],
    'select' => ['ID', 'NAME', 'DESCRIPTION', 'LOGOTIP'],
    'order'  => ['SORT' => 'ASC'],
]);

$payments = [];
while ($row = $dbPayments->fetch()) {
    $logo = null;
    if (!empty($row['LOGOTIP'])) {
        $file = \CFile::GetFileArray($row['LOGOTIP']);
        if ($file) $logo = $file['SRC'];
    }

    $payments[] = [
        'id'          => (int) $row['ID'],
        'name'        => trim($row['NAME']),
        'description' => trim($row['DESCRIPTION'] ?? ''),
        'logo'        => $logo,
    ];
}

api_response([
    'success' => true,
    'data' => [
        'delivery_methods' => $deliveries,
        'payment_methods'  => $payments,
    ],
]);
