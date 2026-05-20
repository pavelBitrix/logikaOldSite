<?php
/**
 * Одноразовый скрипт создания инфоблоков.
 * 1. Загрузи на сервер в ~/public_html/
 * 2. Открой: http://api.logika1c.ru/setup-iblocks.php?secret=logika2026
 * 3. УДАЛИ файл после выполнения
 */

$secret = $_GET['secret'] ?? '';
if ($secret !== 'logika2026') {
    http_response_code(403);
    die('Forbidden. Add ?secret=logika2026');
}

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

\Bitrix\Main\Loader::includeModule('iblock');

header('Content-Type: text/plain; charset=utf-8');

$results = [];

// ── Найти или создать тип инфоблоков ────────────────────────────────────────
$iblockTypeId = 'logika_content';
$type = CIBlockType::GetByID($iblockTypeId)->Fetch();
if (!$type) {
    $ibType = new CIBlockType();
    $ibType->Add([
        'ID'       => $iblockTypeId,
        'LANG'     => ['ru' => ['NAME' => 'Logika — контент']],
        'SECTIONS' => 'Y',
        'IN_RSS'   => 'N',
        'SORT'     => 100,
    ]);
    $results[] = "Тип инфоблоков '$iblockTypeId' создан.";
} else {
    $results[] = "Тип инфоблоков '$iblockTypeId' уже существует.";
}

// ── Инфоблок LOGIKA_LEADS (заявки с сайта) ──────────────────────────────────
$leadsId = getOrCreateIblock('LOGIKA_LEADS', 'Заявки с сайта', $iblockTypeId, [
    ['CODE' => 'PHONE',   'NAME' => 'Телефон',      'PROPERTY_TYPE' => 'S'],
    ['CODE' => 'COMMENT', 'NAME' => 'Комментарий',  'PROPERTY_TYPE' => 'S'],
    ['CODE' => 'SOURCE',  'NAME' => 'Источник',     'PROPERTY_TYPE' => 'S'],
], $results);

// ── Инфоблок LOGIKA_CATALOG (каталог товаров / 1С) ──────────────────────────
$catalogId = getOrCreateIblock('LOGIKA_CATALOG', 'Каталог продуктов', $iblockTypeId, [
    ['CODE' => 'PRICE',       'NAME' => 'Цена',          'PROPERTY_TYPE' => 'N'],
    ['CODE' => 'PRICE_LABEL', 'NAME' => 'Цена (текст)',  'PROPERTY_TYPE' => 'S'],
    ['CODE' => 'VENDOR_CODE', 'NAME' => 'Артикул 1С',   'PROPERTY_TYPE' => 'S'],
], $results);

// ── Вывод результата ─────────────────────────────────────────────────────────
echo implode("\n", $results) . "\n\n";
echo "LOGIKA_LEADS   ID = $leadsId\n";
echo "LOGIKA_CATALOG ID = $catalogId\n\n";
echo "!!! УДАЛИ ЭТОТ ФАЙЛ С СЕРВЕРА !!!\n";

// ── Хелпер ───────────────────────────────────────────────────────────────────
function getOrCreateIblock(string $code, string $name, string $type, array $props, array &$log): int
{
    $res = CIBlock::GetList([], ['CODE' => $code, 'CHECK_PERMISSIONS' => 'N']);
    if ($row = $res->Fetch()) {
        $log[] = "Инфоблок '$code' уже существует (ID={$row['ID']}).";
        return (int) $row['ID'];
    }

    $ib = new CIBlock();
    $id = $ib->Add([
        'NAME'         => $name,
        'CODE'         => $code,
        'IBLOCK_TYPE_ID' => $type,
        'LID'          => ['s1'],
        'ACTIVE'       => 'Y',
        'SORT'         => 100,
        'VERSION'      => 2,
        'INDEX_ELEMENT' => 'N',
        'INDEX_SECTION' => 'N',
    ]);

    if (!$id) {
        $log[] = "ОШИБКА создания '$code': " . $ib->LAST_ERROR;
        return 0;
    }

    $log[] = "Инфоблок '$code' создан (ID=$id).";

    foreach ($props as $prop) {
        $p = new CIBlockProperty();
        $p->Add(array_merge($prop, [
            'IBLOCK_ID' => $id,
            'ACTIVE'    => 'Y',
            'MULTIPLE'  => 'N',
        ]));
    }

    $log[] = "  → добавлено свойств: " . count($props);
    return $id;
}
