<?php
/**
 * GET /local/api/v1/catalog/categories.php
 * Список групп и категорий каталога из инфоблока Bitrix.
 *
 * Response:
 * {
 *   "groups": [ { "id": "software", "label": "...", "sub": "..." } ],
 *   "categories": [ { "id": "fin", "label": "...", "groupId": "software", "count": 3 } ]
 * }
 */

require_once __DIR__ . '/../_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    api_error('Метод не поддерживается', 405);
}

\Bitrix\Main\Loader::includeModule('iblock');

// ID инфоблока каталога — задать через настройки или константу
$IBLOCK_ID = defined('LOGIKA_CATALOG_IBLOCK_ID') ? LOGIKA_CATALOG_IBLOCK_ID : 1;

// ─── Разделы инфоблока → группы и категории ────────────────────────────────
// Структура: корневые разделы — это группы (software / equipment),
// их дочерние разделы — категории.

$groups     = [];
$categories = [];

// Получаем все разделы одним запросом
$res = \CIBlockSection::GetList(
    ['SORT' => 'ASC'],
    ['IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y'],
    false,
    ['ID', 'NAME', 'DEPTH_LEVEL', 'SECTION_PAGE_URL', 'IBLOCK_SECTION_ID', 'CODE', 'UF_GROUP_SUB']
);

$allSections = [];
while ($row = $res->Fetch()) {
    $allSections[] = $row;
}

// Корневые разделы (DEPTH_LEVEL = 1) → группы
// Дочерние (DEPTH_LEVEL = 2) → категории
foreach ($allSections as $section) {
    if ((int)$section['DEPTH_LEVEL'] === 1) {
        $groups[] = [
            'id'    => $section['CODE'],
            'label' => $section['NAME'],
            'sub'   => $section['UF_GROUP_SUB'] ?? '',  // UF-поле "подзаголовок группы"
        ];
    } else {
        // Считаем товары в категории
        $count = \CIBlockElement::GetList(
            [],
            ['IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y', 'SECTION_ID' => $section['ID']],
            [],
            false,
            ['ID']
        );

        $categories[] = [
            'id'      => $section['CODE'],
            'label'   => $section['NAME'],
            'groupId' => '', // заполним ниже
            'count'   => (int)$count->SelectedRowsCount(),
            '_secId'  => (int)$section['ID'],
            '_parentId' => (int)$section['IBLOCK_SECTION_ID'],
        ];
    }
}

// Привязываем категории к группам через ID родителя
$groupById = [];
foreach ($allSections as $s) {
    if ((int)$s['DEPTH_LEVEL'] === 1) {
        $groupById[(int)$s['ID']] = $s['CODE'];
    }
}
foreach ($categories as &$cat) {
    $cat['groupId'] = $groupById[$cat['_parentId']] ?? '';
    unset($cat['_secId'], $cat['_parentId']);
}
unset($cat);

api_response(compact('groups', 'categories'));
