<?php
namespace Logika\Api\Controllers;

use Bitrix\Main\Loader;
use Logika\Api\Response;

class CatalogController
{
    private const IBLOCK_ID = 53;

    /**
     * GET catalog
     * Query: section?, q?, sort?, page?, limit?
     */
    public function index(array $params, array $body): void
    {
        Loader::includeModule('iblock');
        Loader::includeModule('catalog');

        $section = trim($_GET['section'] ?? '');
        $query   = trim($_GET['q']       ?? '');
        $sort    = $_GET['sort']          ?? 'popular';
        $page    = max(1, (int) ($_GET['page']  ?? 1));
        $limit   = min(50, max(1, (int) ($_GET['limit'] ?? 12)));

        // ─── Фильтр ─────────────────────────────────────────────────────────────
        $filter = ['IBLOCK_ID' => self::IBLOCK_ID, 'ACTIVE' => 'Y'];

        if ($section) {
            $secRes = \CIBlockSection::GetList([], ['IBLOCK_ID' => self::IBLOCK_ID, 'CODE' => $section], false, ['ID']);
            if ($sec = $secRes->Fetch()) {
                $filter['SECTION_ID']           = (int) $sec['ID'];
                $filter['INCLUDE_SUBSECTIONS']  = 'Y';
            }
        }

        if ($query) {
            $filter['%NAME'] = $query;
        }

        // ─── Сортировка ──────────────────────────────────────────────────────────
        $order = match($sort) {
            'price-asc'  => ['CATALOG_PRICE_1' => 'ASC'],
            'price-desc' => ['CATALOG_PRICE_1' => 'DESC'],
            'name'       => ['NAME' => 'ASC'],
            'new'        => ['DATE_CREATE' => 'DESC'],
            default      => ['SORT' => 'ASC'],
        };

        // ─── Подсчёт ─────────────────────────────────────────────────────────────
        $total = (int) \CIBlockElement::GetList($order, $filter, false, false, ['ID'])->SelectedRowsCount();
        $pages = (int) ceil($total / $limit);

        // ─── Выборка ─────────────────────────────────────────────────────────────
        $res = \CIBlockElement::GetList(
            $order,
            $filter,
            false,
            ['nPageSize' => $limit, 'iNumPage' => $page],
            ['ID', 'NAME', 'CODE', 'PREVIEW_TEXT', 'DETAIL_PICTURE', 'PREVIEW_PICTURE', 'XML_ID', 'IBLOCK_SECTION_ID', 'PROPERTY_*']
        );

        $items = [];
        while ($el = $res->GetNextElement()) {
            $items[] = $this->formatItem($el->GetFields(), $el->GetProperties());
        }

        Response::success([
            'items'      => $items,
            'pagination' => compact('total', 'page', 'limit', 'pages'),
        ]);
    }

    /**
     * GET catalog/{id}
     */
    public function show(array $params, array $body): void
    {
        Loader::includeModule('iblock');
        Loader::includeModule('catalog');

        $id  = (int) ($params['id'] ?? 0);
        $res = \CIBlockElement::GetList(
            [],
            ['IBLOCK_ID' => self::IBLOCK_ID, 'ID' => $id, 'ACTIVE' => 'Y'],
            false,
            false,
            ['ID', 'NAME', 'CODE', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'XML_ID', 'PROPERTY_*']
        );

        $el = $res->GetNextElement();
        if (!$el) {
            Response::error('Элемент не найден', 404);
        }

        $fields = $el->GetFields();
        $props  = $el->GetProperties();
        $item   = $this->formatItem($fields, $props);

        // Дополнительные поля для детальной страницы
        $item['detail']  = $fields['DETAIL_TEXT'] ?? null;
        $item['picture'] = $fields['DETAIL_PICTURE']
            ? \CFile::GetPath($fields['DETAIL_PICTURE'])
            : $item['picture'];

        Response::success($item);
    }

    /**
     * GET catalog/sections — дерево разделов (для сайдбара)
     */
    public function sections(array $params, array $body): void
    {
        Loader::includeModule('iblock');
        Response::success($this->getSections());
    }

    /**
     * GET catalog/filters — разделы + фильтруемые свойства с диапазонами
     */
    public function filters(array $params, array $body): void
    {
        Loader::includeModule('iblock');
        Response::success([
            'sections'   => $this->getSections(),
            'properties' => $this->getFilterProperties(),
        ]);
    }

    /**
     * GET catalog/{id}/reviews
     */
    public function reviews(array $params, array $body): void
    {
        Loader::includeModule('iblock');

        $productId = (int) ($params['id'] ?? 0);

        // Отзывы хранятся в инфоблоке LOGIKA_REVIEWS с привязкой к товару через свойство PRODUCT_ID
        $reviewIblock = \CIBlock::GetList([], ['CODE' => 'LOGIKA_REVIEWS', 'CHECK_PERMISSIONS' => 'N'])->Fetch();
        if (!$reviewIblock) {
            Response::success(['items' => [], 'total' => 0]);
        }

        $res = \CIBlockElement::GetList(
            ['DATE_CREATE' => 'DESC'],
            ['IBLOCK_ID' => $reviewIblock['ID'], 'PROPERTY_PRODUCT_ID' => $productId, 'ACTIVE' => 'Y'],
            false,
            ['nPageSize' => 20, 'iNumPage' => 1],
            ['ID', 'NAME', 'PREVIEW_TEXT', 'DATE_CREATE', 'PROPERTY_RATING', 'PROPERTY_AUTHOR_NAME']
        );

        $items = [];
        while ($row = $res->GetNext()) {
            $items[] = [
                'id'          => (int) $row['ID'],
                'author'      => $row['PROPERTY_AUTHOR_NAME_VALUE'] ?: $row['NAME'],
                'text'        => $row['PREVIEW_TEXT'],
                'rating'      => (int) ($row['PROPERTY_RATING_VALUE'] ?? 5),
                'date'        => $row['DATE_CREATE'],
            ];
        }

        Response::success(['items' => $items, 'total' => count($items)]);
    }

    /**
     * POST catalog/{id}/reviews  — добавить отзыв (пользователь)
     */
    public function addReview(array $params, array $body): void
    {
        Loader::includeModule('iblock');

        $productId = (int) ($params['id'] ?? 0);
        $text      = trim($body['text']   ?? '');
        $rating    = max(1, min(5, (int) ($body['rating'] ?? 5)));
        $author    = trim($body['author_name'] ?? 'Аноним');

        if (!$text) {
            Response::error('Текст отзыва обязателен', 422);
        }

        $reviewIblock = \CIBlock::GetList([], ['CODE' => 'LOGIKA_REVIEWS', 'CHECK_PERMISSIONS' => 'N'])->Fetch();
        if (!$reviewIblock) {
            Response::error('Функция отзывов не настроена', 500);
        }

        $el = new \CIBlockElement();
        $id = $el->Add([
            'IBLOCK_ID'       => $reviewIblock['ID'],
            'NAME'            => "Отзыв — $author",
            'ACTIVE'          => 'N', // модерация
            'PREVIEW_TEXT'    => $text,
            'PROPERTY_VALUES' => [
                'PRODUCT_ID'  => $productId,
                'RATING'      => $rating,
                'AUTHOR_NAME' => $author,
            ],
        ]);

        if (!$id) {
            Response::error($el->LAST_ERROR ?: 'Ошибка сохранения', 500);
        }

        Response::success(['review_id' => (int) $id, 'pending' => true], 201);
    }

    // ─── Приватные методы ─────────────────────────────────────────────────────

    private function formatItem(array $fields, array $props): array
    {
        $id = (int) $fields['ID'];

        // Цена из каталожного модуля
        $priceData = \CPrice::GetBasePrice($id);
        $price     = $priceData ? (float) $priceData['PRICE'] : null;

        // Детальная картинка приоритетнее превью — она всегда лучшего качества
        $picture = null;
        $picId   = $fields['DETAIL_PICTURE'] ?? $fields['PREVIEW_PICTURE'] ?? null;
        if ($picId) {
            $picture = \CFile::GetPath($picId);
        }

        // Наличие и количество читаем напрямую из b_catalog_product —
        // CCatalogProduct::GetByIDEx() иногда возвращает false при наличии записи в БД.
        // Логика:
        //   QUANTITY > 0  → реальный остаток, доверяем напрямую
        //   QUANTITY = 0, QUANTITY_TRACE = N  → учёт отключён, доступность = есть цена
        //   QUANTITY = 0, QUANTITY_TRACE = Y  → на этом сайте учёт не ведётся, доступность = есть цена
        //   нет записи в b_catalog_product   → доступность = есть цена (+ свойство IN_STOCK)
        global $DB;
        $prodRow = $DB->Query(
            "SELECT QUANTITY, QUANTITY_TRACE FROM b_catalog_product WHERE ID = " . $id
        )->Fetch();

        $quantity = 0;

        if ($prodRow !== false) {
            $quantity      = (int) ($prodRow['QUANTITY'] ?? 0);
            $quantityTrace = $prodRow['QUANTITY_TRACE'] ?? 'Y';

            if ($quantity > 0) {
                $inStock = true;
            } else {
                // QUANTITY_TRACE = N → учёт выключен; Y → учёт «включён» но не ведётся на сайте.
                // В обоих случаях доступность определяем по цене.
                $inStock  = ($price !== null);
                $quantity = $inStock ? 1 : 0;
            }
        } elseif (!empty($props['IN_STOCK']['VALUE'])) {
            $val      = strtolower(trim($props['IN_STOCK']['VALUE']));
            $inStock  = in_array($val, ['y', 'yes', 'да', '1', 'true', 'в наличии'], true);
            $quantity = $inStock ? 1 : 0;
        } else {
            $inStock  = ($price !== null);
            $quantity = $inStock ? 1 : 0;
        }

        return [
            'id'           => $id,
            'name'         => $fields['NAME'],
            'code'         => $fields['CODE'],
            'xml_id'       => $fields['XML_ID'] ?? null,
            'section_id'   => (int) ($fields['IBLOCK_SECTION_ID'] ?? 0),
            'preview'      => $fields['PREVIEW_TEXT'] ?? null,
            'picture'      => $picture,
            'price'        => $price,
            'price_label'  => $props['PRICE_LABEL']['VALUE'] ?? 'от',
            'currency'     => 'RUB',
            'in_stock'     => $inStock,
            'quantity'     => $quantity,
            'badge'        => $props['BADGE']['VALUE']     ?? null,
            'kind'         => $props['KIND']['VALUE']      ?? null,
            'edition'      => $props['EDITION']['VALUE']   ?? null,
            'deploy'       => $props['DEPLOY']['VALUE']    ?? null,
            'illustration' => $props['ILLUSTRATION']['VALUE'] ?? null,
            'tags'         => array_values(array_filter((array) ($props['TAGS']['VALUE']     ?? []))),
            'features'     => array_values(array_filter((array) ($props['FEATURES']['VALUE'] ?? []))),
        ];
    }

    private function getSections(): array
    {
        $res = \CIBlockSection::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => self::IBLOCK_ID, 'ACTIVE' => 'Y'],
            false,
            ['ID', 'NAME', 'CODE', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID', 'UF_GROUP_SUB']
        );

        // Actual element counts per section (single SQL — faster and always accurate)
        global $DB;
        $cntRes = $DB->Query(
            "SELECT IBLOCK_SECTION_ID, COUNT(*) cnt
             FROM b_iblock_element
             WHERE IBLOCK_ID = " . self::IBLOCK_ID . " AND ACTIVE = 'Y'
             GROUP BY IBLOCK_SECTION_ID"
        );
        $directCounts = [];
        while ($cr = $cntRes->Fetch()) {
            $directCounts[(int) $cr['IBLOCK_SECTION_ID']] = (int) $cr['cnt'];
        }

        $sections = [];
        while ($row = $res->GetNext()) {
            $sections[] = [
                'id'        => (int) $row['ID'],
                'name'      => $row['NAME'],
                'code'      => $row['CODE'],
                'sub'       => $row['UF_GROUP_SUB'] ?? '',
                'depth'     => (int) $row['DEPTH_LEVEL'],
                'parent_id' => (int) ($row['IBLOCK_SECTION_ID'] ?: 0),
                'count'     => $directCounts[(int) $row['ID']] ?? 0,
            ];
        }

        // Propagate child counts to parent sections
        $childSum = [];
        foreach ($sections as $s) {
            if ($s['parent_id'] > 0) {
                $childSum[$s['parent_id']] = ($childSum[$s['parent_id']] ?? 0) + $s['count'];
            }
        }
        foreach ($sections as &$s) {
            if (isset($childSum[$s['id']])) {
                $s['count'] += $childSum[$s['id']];
            }
        }
        unset($s);

        return $sections;
    }

    private function getFilterProperties(): array
    {
        $res   = \CIBlockProperty::GetList(['SORT' => 'ASC'], ['IBLOCK_ID' => self::IBLOCK_ID, 'ACTIVE' => 'Y']);
        $props = [];

        while ($prop = $res->Fetch()) {
            $entry = [
                'id'   => (int) $prop['ID'],
                'code' => $prop['CODE'],
                'name' => $prop['NAME'],
                'type' => $prop['PROPERTY_TYPE'],
            ];

            if ($prop['PROPERTY_TYPE'] === 'L') {
                $vals = [];
                $vRes = \CIBlockPropertyEnum::GetList(['SORT' => 'ASC'], ['PROPERTY_ID' => $prop['ID']]);
                while ($v = $vRes->Fetch()) {
                    $vals[] = ['id' => (int) $v['ID'], 'value' => $v['VALUE']];
                }
                $entry['values'] = $vals;
            }

            if ($prop['PROPERTY_TYPE'] === 'N') {
                $entry['range'] = $this->getPropertyRange((int) $prop['ID']);
            }

            $props[] = $entry;
        }
        return $props;
    }

    private function getPropertyRange(int $propId): array
    {
        global $DB;
        $res = $DB->Query(
            "SELECT MIN(CAST(VALUE AS DECIMAL(15,2))) min_val, MAX(CAST(VALUE AS DECIMAL(15,2))) max_val
             FROM b_iblock_element_property WHERE IBLOCK_PROPERTY_ID = $propId AND VALUE <> ''"
        );
        $row = $res->Fetch();
        return ['min' => (float) ($row['min_val'] ?? 0), 'max' => (float) ($row['max_val'] ?? 0)];
    }
}
