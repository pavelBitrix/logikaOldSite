<?php
namespace Logika\Api\Controllers;

use Bitrix\Main\Loader;
use Bitrix\Sale\Order;
use Bitrix\Sale\Basket;
use Bitrix\Sale\BasketItem;
use Logika\Api\Response;

class OrderController
{
    public function index(array $params, array $body): void
    {
        Loader::includeModule('sale');

        // Return last 50 orders (admin usage)
        $orders = Order::getList([
            'select' => ['ID', 'DATE_INSERT', 'PRICE', 'STATUS_ID', 'USER_ID'],
            'order'  => ['DATE_INSERT' => 'DESC'],
            'limit'  => 50,
        ])->fetchAll();

        Response::success($orders);
    }

    public function create(array $params, array $body): void
    {
        Loader::includeModule('sale');
        Loader::includeModule('catalog');

        $userId  = (int) ($body['user_id']   ?? 0);
        $siteId  = SITE_ID ?? 's1';
        $items   = $body['items'] ?? [];

        if (empty($items)) {
            Response::error('Список товаров пуст', 422);
        }

        $order  = Order::create($siteId, $userId ?: null);
        $order->setPersonTypeId(1);

        $basket = Basket::create($siteId);
        foreach ($items as $row) {
            $basketItem = $basket->createItem('catalog', (int) $row['product_id']);
            $basketItem->setFields([
                'QUANTITY' => (int) ($row['quantity'] ?? 1),
                'CURRENCY' => 'RUB',
                'LID'      => $siteId,
            ]);
        }

        $order->setBasket($basket);
        $result = $order->save();

        if (!$result->isSuccess()) {
            Response::error(implode('; ', $result->getErrorMessages()), 500);
        }

        Response::success(['order_id' => $order->getId()], 201);
    }

    public function show(array $params, array $body): void
    {
        Loader::includeModule('sale');

        $id    = (int) ($params['id'] ?? 0);
        $order = Order::load($id);

        if (!$order) {
            Response::error('Заказ не найден', 404);
        }

        Response::success([
            'id'         => $order->getId(),
            'status'     => $order->getField('STATUS_ID'),
            'price'      => $order->getPrice(),
            'date'       => $order->getDateInsert()->toString(),
            'xml_id'     => $order->getField('XML_ID'), // 1C order ID
        ]);
    }
}
