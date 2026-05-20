<?php
namespace Logika\Api\Controllers;

use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use Logika\Api\Response;

class CartController
{
    private function load(): Basket
    {
        Loader::includeModule('sale');
        Loader::includeModule('catalog');
        return Basket::loadItemsForFUser(Fuser::getId(true), SITE_ID);
    }

    /**
     * GET cart
     */
    public function index(array $params, array $body): void
    {
        $basket = $this->load();
        Response::success($this->format($basket));
    }

    /**
     * POST cart/add
     * Body: { product_id, quantity? }
     */
    public function add(array $params, array $body): void
    {
        $productId = (int) ($body['product_id'] ?? 0);
        $quantity  = max(1, (int) ($body['quantity'] ?? 1));

        if (!$productId) {
            Response::error('product_id обязателен', 422);
        }

        $basket   = $this->load();
        $existing = $basket->getExistsItem('catalog', $productId);

        if ($existing) {
            $existing->setField('QUANTITY', $existing->getQuantity() + $quantity);
        } else {
            $item = $basket->createItem('catalog', $productId);
            $item->setFields([
                'QUANTITY'               => $quantity,
                'CURRENCY'               => 'RUB',
                'LID'                    => SITE_ID,
                'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
            ]);
        }

        $result = $basket->save();
        if (!$result->isSuccess()) {
            Response::error(implode('; ', $result->getErrorMessages()), 500);
        }

        Response::success($this->format($basket));
    }

    /**
     * PUT cart/{itemId}
     * Body: { quantity }
     */
    public function update(array $params, array $body): void
    {
        $itemId   = (int) ($params['itemId'] ?? 0);
        $quantity = max(0, (int) ($body['quantity'] ?? 0));

        $basket = $this->load();

        foreach ($basket->getBasketItems() as $item) {
            if ($item->getId() === $itemId) {
                if ($quantity === 0) {
                    $item->delete();
                } else {
                    $item->setField('QUANTITY', $quantity);
                }
                $basket->save();
                Response::success($this->format($basket));
            }
        }

        Response::error('Позиция не найдена', 404);
    }

    /**
     * DELETE cart/{itemId}
     */
    public function remove(array $params, array $body): void
    {
        $itemId = (int) ($params['itemId'] ?? 0);
        $basket = $this->load();

        foreach ($basket->getBasketItems() as $item) {
            if ($item->getId() === $itemId) {
                $item->delete();
                $basket->save();
                Response::success($this->format($basket));
            }
        }

        Response::error('Позиция не найдена', 404);
    }

    /**
     * DELETE cart  — очистить корзину
     */
    public function clear(array $params, array $body): void
    {
        $basket = $this->load();
        $basket->clearCollection();
        $basket->save();
        Response::success($this->format($basket));
    }

    // ─── Format ────────────────────────────────────────────────────────────────

    private function format(Basket $basket): array
    {
        $items = [];
        foreach ($basket->getBasketItems() as $item) {
            $picture = null;
            if ($picId = $item->getField('DETAIL_PAGE_URL')) {
                $picture = $picId; // или CFile::GetPath если хранится ID
            }

            $items[] = [
                'id'         => $item->getId(),
                'product_id' => $item->getProductId(),
                'name'       => $item->getField('NAME'),
                'price'      => (float) $item->getPrice(),
                'quantity'   => (int) $item->getQuantity(),
                'sum'        => (float) $item->getFinalPrice(),
                'picture'    => $item->getField('PREVIEW_PICTURE'),
                'xml_id'     => $item->getField('PRODUCT_XML_ID'),
            ];
        }

        return [
            'items'    => $items,
            'total'    => (float) $basket->getPrice(),
            'currency' => 'RUB',
            'count'    => count($items),
        ];
    }
}
