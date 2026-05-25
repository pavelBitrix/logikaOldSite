<?php
require_once __DIR__ . '/../../_bootstrap.php';

$user = api_require_auth();
$userId = (int) $user['id'];

$page  = max(1, (int) ($_GET['page']  ?? 1));
$limit = min(50, max(1, (int) ($_GET['limit'] ?? 10)));
$offset = ($page - 1) * $limit;

// Корректный способ получить заказы в Bitrix: OrderTable, не Order::getCount()
$total = \Bitrix\Sale\Internals\OrderTable::getCount(['=USER_ID' => $userId]);

$dbOrders = \Bitrix\Sale\Internals\OrderTable::getList([
    'filter'  => ['=USER_ID' => $userId],
    'select'  => ['ID', 'ACCOUNT_NUMBER', 'DATE_INSERT', 'STATUS_ID', 'PRICE'],
    'order'   => ['DATE_INSERT' => 'DESC'],
    'limit'   => $limit,
    'offset'  => $offset,
]);

$orders = [];
while ($row = $dbOrders->fetch()) {
    $orderId = (int) $row['ID'];

    // Товары заказа
    $items = [];
    $dbItems = \Bitrix\Sale\Internals\BasketTable::getList([
        'filter' => ['=ORDER_ID' => $orderId],
        'select' => ['NAME', 'QUANTITY', 'PRICE'],
    ]);
    while ($item = $dbItems->fetch()) {
        $items[] = [
            'id'       => null,
            'name'     => $item['NAME'],
            'quantity' => (int) $item['QUANTITY'],
            'price'    => (float) $item['PRICE'],
        ];
    }

    // Статус: маппинг Bitrix → наш формат
    $statusMap = [
        'N'  => 'new',
        'P'  => 'processing',
        'F'  => 'completed',
        'C'  => 'cancelled',
    ];
    $statusId  = $row['STATUS_ID'] ?? 'N';
    $status    = $statusMap[$statusId] ?? 'new';

    $orders[] = [
        'id'     => $orderId,
        'date'   => $row['DATE_INSERT'] instanceof \Bitrix\Main\Type\DateTime
            ? $row['DATE_INSERT']->format('Y-m-d\TH:i:s')
            : (string) $row['DATE_INSERT'],
        'status' => $status,
        'total'  => (float) $row['PRICE'],
        'items'  => $items,
    ];
}

api_response([
    'orders'     => $orders,
    'pagination' => [
        'page'  => $page,
        'limit' => $limit,
        'total' => $total,
        'pages' => (int) ceil($total / $limit),
    ],
]);
