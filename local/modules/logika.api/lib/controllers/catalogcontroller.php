<?php
namespace Logika\Api\Controllers;

use Bitrix\Main\Loader;
use Bitrix\Iblock\ElementTable;
use Logika\Api\Response;

class CatalogController
{
    // ID инфоблока "Основной каталог товаров Логика"
    private const IBLOCK_ID = 53;

    public function index(array $params, array $body): void
    {
        Loader::includeModule('iblock');

        $iblockId = $this->getIblockId();

        $result = \CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'],
            false,
            ['nPageSize' => 100],
            ['ID', 'NAME', 'CODE', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'PROPERTY_*']
        );

        $items = [];
        while ($item = $result->GetNext()) {
            $items[] = $this->formatItem($item);
        }

        Response::success($items);
    }

    public function show(array $params, array $body): void
    {
        Loader::includeModule('iblock');

        $id       = (int) ($params['id'] ?? 0);
        $iblockId = $this->getIblockId();

        $result = \CIBlockElement::GetList(
            [],
            ['IBLOCK_ID' => $iblockId, 'ID' => $id, 'ACTIVE' => 'Y'],
            false,
            false,
            ['ID', 'NAME', 'CODE', 'DETAIL_TEXT', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_*']
        );

        $item = $result->GetNext();
        if (!$item) {
            Response::error('Элемент не найден', 404);
        }

        Response::success($this->formatItem($item));
    }

    // Возвращает разделы + все свойства с уникальными значениями для фильтров
    public function filters(array $params, array $body): void
    {
        Loader::includeModule('iblock');

        Response::success([
            'sections'   => $this->getSections(),
            'properties' => $this->getFilterProperties(),
        ]);
    }

    // Только дерево разделов (для сайдбара / меню)
    public function sections(array $params, array $body): void
    {
        Loader::includeModule('iblock');
        Response::success($this->getSections());
    }

    private function getSections(): array
    {
        $res = \CIBlockSection::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => self::IBLOCK_ID, 'ACTIVE' => 'Y'],
            false,
            ['ID', 'NAME', 'CODE', 'DEPTH_LEVEL', 'SECTION_PAGE_URL', 'IBLOCK_SECTION_ID', 'ELEMENT_CNT']
        );

        $sections = [];
        while ($row = $res->GetNext()) {
            $sections[] = [
                'id'        => (int) $row['ID'],
                'name'      => $row['NAME'],
                'code'      => $row['CODE'],
                'depth'     => (int) $row['DEPTH_LEVEL'],
                'parent_id' => (int) ($row['IBLOCK_SECTION_ID'] ?: 0),
                'count'     => (int) $row['ELEMENT_CNT'],
            ];
        }

        return $sections;
    }

    private function getFilterProperties(): array
    {
        // Получаем все свойства инфоблока типа список (L) и строка (S) — они фильтруемые
        $res = \CIBlockProperty::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => self::IBLOCK_ID, 'ACTIVE' => 'Y']
        );

        $properties = [];
        while ($prop = $res->Fetch()) {
            $type = $prop['PROPERTY_TYPE']; // S, N, L, F, E

            $entry = [
                'id'   => (int) $prop['ID'],
                'code' => $prop['CODE'],
                'name' => $prop['NAME'],
                'type' => $type,
            ];

            // Для списков добавляем перечень значений
            if ($type === 'L') {
                $vals = [];
                $vRes = \CIBlockPropertyEnum::GetList(
                    ['SORT' => 'ASC'],
                    ['PROPERTY_ID' => $prop['ID']]
                );
                while ($v = $vRes->Fetch()) {
                    $vals[] = ['id' => (int) $v['ID'], 'value' => $v['VALUE']];
                }
                $entry['values'] = $vals;
            }

            // Для чисел добавляем min/max по реальным данным
            if ($type === 'N') {
                $entry['range'] = $this->getPropertyRange($prop['ID']);
            }

            $properties[] = $entry;
        }

        return $properties;
    }

    private function getPropertyRange(int $propId): array
    {
        global $DB;
        $sql = "SELECT MIN(CAST(VALUE AS DECIMAL)) as min_val,
                       MAX(CAST(VALUE AS DECIMAL)) as max_val
                FROM b_iblock_element_property
                WHERE IBLOCK_PROPERTY_ID = $propId AND VALUE != ''";
        $res = $DB->Query($sql);
        $row = $res->Fetch();
        return [
            'min' => (float) ($row['min_val'] ?? 0),
            'max' => (float) ($row['max_val'] ?? 0),
        ];
    }

    private function formatItem(array $raw): array
    {
        return [
            'id'          => (int) $raw['ID'],
            'name'        => $raw['NAME'],
            'code'        => $raw['CODE'],
            'preview'     => $raw['PREVIEW_TEXT'] ?? null,
            'detail'      => $raw['DETAIL_TEXT']  ?? null,
            'picture'     => $raw['PREVIEW_PICTURE'] ? \CFile::GetPath($raw['PREVIEW_PICTURE']) : null,
            'price'       => $raw['PROPERTY_PRICE_VALUE'] ?? null,
            'xml_id'      => $raw['XML_ID'] ?? null, // 1C external ID
        ];
    }

    private function getIblockId(): int
    {
        return self::IBLOCK_ID;
    }
}