<?php
namespace Logika\Api\Controllers;

use Bitrix\Main\Loader;
use Logika\Api\Auth\UserAuth;
use Logika\Api\Response;

/**
 * Избранное реализовано через пользовательское поле b_uts_user.UF_WISHLIST (тип: multiple string).
 * Альтернатива — отдельная таблица или инфоблок. Здесь используем UF для простоты.
 */
class WishlistController
{
    private function getList(int $userId): array
    {
        $res = \CUser::GetByID($userId);
        $row = $res->Fetch();
        $raw = $row['UF_WISHLIST'] ?? [];
        return array_values(array_filter(is_array($raw) ? $raw : explode(',', (string) $raw)));
    }

    private function save(int $userId, array $ids): void
    {
        $cUser = new \CUser();
        $cUser->Update($userId, ['UF_WISHLIST' => $ids]);
    }

    /**
     * GET wishlist
     */
    public function index(array $params, array $body): void
    {
        Loader::includeModule('iblock');

        $userId = UserAuth::id();
        $ids    = $this->getList($userId);

        if (empty($ids)) {
            Response::success(['items' => [], 'total' => 0]);
        }

        $items = [];
        $res   = \CIBlockElement::GetList(
            [],
            ['ID' => $ids, 'ACTIVE' => 'Y'],
            false,
            false,
            ['ID', 'NAME', 'CODE', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'PROPERTY_PRICE', 'PROPERTY_KIND']
        );

        while ($el = $res->GetNextElement()) {
            $f = $el->GetFields();
            $p = $el->GetProperties();

            $priceData = \CPrice::GetBasePrice((int) $f['ID']);
            $picture   = $f['PREVIEW_PICTURE'] ? \CFile::GetPath($f['PREVIEW_PICTURE']) : null;

            $items[] = [
                'id'      => (int) $f['ID'],
                'name'    => $f['NAME'],
                'code'    => $f['CODE'],
                'preview' => $f['PREVIEW_TEXT'],
                'picture' => $picture,
                'price'   => $priceData ? (float) $priceData['PRICE'] : null,
                'kind'    => $p['KIND']['VALUE'] ?? null,
            ];
        }

        Response::success(['items' => $items, 'total' => count($items)]);
    }

    /**
     * POST wishlist
     * Body: { product_id }
     */
    public function add(array $params, array $body): void
    {
        $productId = (string) ((int) ($body['product_id'] ?? 0));
        if (!$productId) {
            Response::error('product_id обязателен', 422);
        }

        $userId = UserAuth::id();
        $list   = $this->getList($userId);

        if (!in_array($productId, $list, true)) {
            $list[] = $productId;
            $this->save($userId, $list);
        }

        Response::success(['product_id' => (int) $productId, 'in_wishlist' => true]);
    }

    /**
     * DELETE wishlist/{productId}
     */
    public function remove(array $params, array $body): void
    {
        $productId = (string) ((int) ($params['productId'] ?? 0));
        $userId    = UserAuth::id();
        $list      = array_filter($this->getList($userId), fn($id) => $id !== $productId);

        $this->save($userId, array_values($list));
        Response::success(['product_id' => (int) $productId, 'in_wishlist' => false]);
    }

    /**
     * GET wishlist/check/{productId}  — быстрая проверка без загрузки всего списка
     */
    public function check(array $params, array $body): void
    {
        $productId = (string) ((int) ($params['productId'] ?? 0));
        $list      = $this->getList(UserAuth::id());
        Response::success(['product_id' => (int) $productId, 'in_wishlist' => in_array($productId, $list, true)]);
    }
}
