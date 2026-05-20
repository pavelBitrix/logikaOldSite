<?php
/**
 * GET /local/api/v1/catalog/products.php
 * Список товаров каталога с фильтрацией, сортировкой и пагинацией.
 *
 * Query params:
 *   category  — CODE раздела (или пусто / "all" = все)
 *   q         — поисковый запрос
 *   sort      — popular | price-asc | price-desc | name
 *   page      — номер страницы (default: 1)
 *   limit     — кол-во на странице (default: 12, max: 50)
 *
 * Response:
 * {
 *   "items": [ { CatalogItem } ],
 *   "pagination": { "total": N, "page": 1, "limit": 12, "pages": N }
 * }
 */

require_once __DIR__ . '/../_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    api_error('Метод не поддерживается', 405);
}

\Bitrix\Main\Loader::includeModule('iblock');
\Bitrix\Main\Loader::includeModule('catalog');

$IBLOCK_ID = defined('LOGIKA_CATALOG_IBLOCK_ID') ? LOGIKA_CATALOG_IBLOCK_ID : 1;

// ─── Параметры запроса ────────────────────────────────────────────────────────
$categoryCode = trim($_GET['category'] ?? '');
$query        = trim($_GET['q'] ?? '');
$sort         = $_GET['sort'] ?? 'popular';
$page         = max(1, (int)($_GET['page'] ?? 1));
$limit        = min(50, max(1, (int)($_GET['limit'] ?? 12)));

// ─── Фильтр ───────────────────────────────────────────────────────────────────
$filter = ['IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y'];

if ($categoryCode && $categoryCode !== 'all') {
    // Находим раздел по CODE
    $secRes = \CIBlockSection::GetList(
        [],
        ['IBLOCK_ID' => $IBLOCK_ID, 'CODE' => $categoryCode],
        false,
        ['ID']
    );
    if ($sec = $secRes->Fetch()) {
        $filter['SECTION_ID'] = (int)$sec['ID'];
        $filter['INCLUDE_SUBSECTIONS'] = 'Y';
    }
}

if ($query) {
    $filter['%NAME'] = $query;
}

// ─── Сортировка ───────────────────────────────────────────────────────────────
$order = match($sort) {
    'price-asc'  => ['CATALOG_PRICE_1' => 'ASC'],
    'price-desc' => ['CATALOG_PRICE_1' => 'DESC'],
    'name'       => ['NAME' => 'ASC'],
    default      => ['SORT' => 'ASC', 'ID' => 'DESC'],  // popular
};

// ─── Выборка ──────────────────────────────────────────────────────────────────
$select = [
    'ID', 'NAME', 'CODE', 'DETAIL_TEXT', 'PREVIEW_TEXT',
    'DETAIL_PICTURE', 'PREVIEW_PICTURE',
    'IBLOCK_SECTION_ID', 'SORT',
    // UF/свойства — получаем через GetProperty после
];

// Считаем общее количество
$countRes = \CIBlockElement::GetList($order, $filter, [], false, ['ID']);
$total    = (int)$countRes->SelectedRowsCount();
$pages    = (int)ceil($total / $limit);

// Получаем нужную страницу
$res = \CIBlockElement::GetList(
    $order,
    $filter,
    false,
    ['nPageSize' => $limit, 'iNumPage' => $page],
    $select
);

// ─── Формирование ответа ──────────────────────────────────────────────────────
$items = [];

while ($el = $res->GetNextElement()) {
    $fields = $el->GetFields();
    $props  = $el->GetProperties();

    // Цена (тип цены 1 = базовая)
    $priceData = \CPrice::GetBasePrice((int)$fields['ID']);
    $price     = $priceData ? (int)$priceData['PRICE'] : 0;

    // Картинка
    $imageUrl = null;
    $picId = $fields['DETAIL_PICTURE'] ?: $fields['PREVIEW_PICTURE'];
    if ($picId) {
        $file = \CFile::GetFileArray($picId);
        if ($file) {
            $imageUrl = \CFile::GetFileSRC($file);
        }
    }

    // Наличие из складского учёта
    $amount  = (int)(\CCatalogProduct::GetByIDEx((int)$fields['ID'])['QUANTITY'] ?? 0);
    $inStock = $amount > 0;

    $items[] = [
        'id'          => (string)$fields['ID'],
        'kind'        => $props['KIND']['VALUE'] ?? 'equipment',           // свойство: software / equipment
        'cat'         => $props['CAT_CODE']['VALUE'] ?? '',                // свойство: код категории
        'catLabel'    => $props['CAT_LABEL']['VALUE'] ?? '',               // свойство: название категории
        'title'       => $fields['NAME'],
        'edition'     => $props['EDITION']['VALUE'] ?? null,               // свойство: редакция
        'tagline'     => $fields['PREVIEW_TEXT'] ?? '',
        'desc'        => $fields['DETAIL_TEXT'] ?? '',
        'features'    => array_values(array_filter((array)($props['FEATURES']['VALUE'] ?? []))),
        'tags'        => array_values(array_filter((array)($props['TAGS']['VALUE'] ?? []))),
        'price'       => $price,
        'priceLabel'  => $props['PRICE_LABEL']['VALUE'] ?? 'от',
        'badge'       => $props['BADGE']['VALUE'] ?? null,
        'deploy'      => $props['DEPLOY']['VALUE'] ?? '',                  // свойство: срок поставки/внедрения
        'illustration'=> $props['ILLUSTRATION']['VALUE'] ?? null,          // свойство: тип SVG (kkt, scanner…)
        'imageUrl'    => $imageUrl,
        'inStock'     => $inStock,
    ];
}

api_response([
    'items'      => $items,
    'pagination' => [
        'total' => $total,
        'page'  => $page,
        'limit' => $limit,
        'pages' => $pages,
    ],
]);
