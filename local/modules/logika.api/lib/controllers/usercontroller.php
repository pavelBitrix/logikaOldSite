<?php
namespace Logika\Api\Controllers;

use Bitrix\Main\Loader;
use Bitrix\Sale\Internals\OrderTable;
use Bitrix\Sale\Order;
use Logika\Api\Auth\UserAuth;
use Logika\Api\Response;

class UserController
{
    /**
     * GET profile
     */
    public function profile(array $params, array $body): void
    {
        global $USER;

        $userId = UserAuth::id();
        $data   = \CUser::GetByID($userId)->Fetch();

        Response::success([
            'id'    => $userId,
            'email' => $data['EMAIL'],
            'name'  => trim($data['NAME'] . ' ' . $data['LAST_NAME']),
            'phone' => $data['PERSONAL_PHONE'] ?? '',
        ]);
    }

    /**
     * PATCH profile
     * Body: { name?, phone?, password?, old_password? }
     */
    public function updateProfile(array $params, array $body): void
    {
        global $USER;

        $userId = UserAuth::id();
        $fields = [];

        if (!empty($body['name'])) {
            $parts = explode(' ', trim($body['name']), 2);
            $fields['NAME']      = $parts[0];
            $fields['LAST_NAME'] = $parts[1] ?? '';
        }

        if (!empty($body['phone'])) {
            $fields['PERSONAL_PHONE'] = trim($body['phone']);
        }

        // Смена пароля
        if (!empty($body['password']) && !empty($body['old_password'])) {
            if (!$USER->CheckPassword(UserAuth::id(), $body['old_password'])) {
                Response::error('Неверный текущий пароль', 422);
            }
            $fields['PASSWORD']         = $body['password'];
            $fields['CONFIRM_PASSWORD'] = $body['password'];
        }

        if (empty($fields)) {
            Response::error('Нечего обновлять', 422);
        }

        $cUser  = new \CUser();
        $result = $cUser->Update($userId, $fields);

        if (!$result) {
            Response::error($cUser->LAST_ERROR ?: 'Ошибка обновления', 500);
        }

        Response::success(UserAuth::current());
    }

    /**
     * GET profile/orders — заказы текущего пользователя
     */
    public function orders(array $params, array $body): void
    {
        Loader::includeModule('sale');

        $userId = UserAuth::id();
        $page   = max(1, (int) ($_GET['page'] ?? 1));
        $limit  = min(50, max(1, (int) ($_GET['limit'] ?? 10)));

        $total = (int) OrderTable::getCount(['=USER_ID' => $userId]);
        $rows  = OrderTable::getList([
            'select' => ['ID', 'DATE_INSERT', 'PRICE', 'STATUS_ID', 'CURRENCY', 'XML_ID'],
            'filter' => ['=USER_ID' => $userId],
            'order'  => ['DATE_INSERT' => 'DESC'],
            'limit'  => $limit,
            'offset' => ($page - 1) * $limit,
        ])->fetchAll();

        $orders = array_map(function ($r) {
            $date = $r['DATE_INSERT'];
            if ($date instanceof \Bitrix\Main\Type\DateTime) {
                $date = $date->toString();
            }

            return [
                'id'         => (int) $r['ID'],
                'date'       => (string) $date,
                'price'      => (float) $r['PRICE'],
                'currency'   => $r['CURRENCY'],
                'status'     => $r['STATUS_ID'],
                'status_name'=> $this->statusName($r['STATUS_ID']),
                'xml_id'     => $r['XML_ID'],
            ];
        }, $rows);

        Response::success([
            'orders'     => $orders,
            'pagination' => [
                'total' => $total,
                'page'  => $page,
                'limit' => $limit,
                'pages' => (int) ceil($total / $limit),
            ],
        ]);
    }

    /**
     * GET profile/orders/{id}
     */
    public function orderDetail(array $params, array $body): void
    {
        Loader::includeModule('sale');

        $id    = (int) ($params['id'] ?? 0);
        $order = Order::load($id);

        if (!$order || $order->getUserId() !== UserAuth::id()) {
            Response::error('Заказ не найден', 404);
        }

        $items = [];
        foreach ($order->getBasket()->getBasketItems() as $item) {
            $items[] = [
                'product_id' => $item->getProductId(),
                'name'       => $item->getField('NAME'),
                'price'      => (float) $item->getPrice(),
                'quantity'   => (int) $item->getQuantity(),
                'sum'        => (float) $item->getFinalPrice(),
            ];
        }

        $props = [];
        foreach ($order->getPropertyCollection() as $prop) {
            $props[$prop->getField('CODE')] = $prop->getValue();
        }

        Response::success([
            'id'          => $order->getId(),
            'date'        => $order->getDateInsert()->toString(),
            'price'       => $order->getPrice(),
            'currency'    => $order->getCurrency(),
            'status'      => $order->getField('STATUS_ID'),
            'status_name' => $this->statusName($order->getField('STATUS_ID')),
            'xml_id'      => $order->getField('XML_ID'),
            'items'       => $items,
            'properties'  => $props,
        ]);
    }

    private function statusName(string $statusId): string
    {
        return match($statusId) {
            'N'  => 'Новый',
            'P'  => 'Принят',
            'A'  => 'Авторизован',
            'D'  => 'Доставляется',
            'F'  => 'Выполнен',
            'C'  => 'Отменён',
            default => $statusId,
        };
    }
}
