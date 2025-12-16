<?php

/**
 * API для получения данных умного фильтра Bitrix
 * Endpoint: /api/v1/catalog/filters
 * Метод: GET
 * Параметры: section_id={id} или section_code={code}
 * Без параметров - вернет фильтры для всех товаров
 */

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Iblock\SectionTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Highloadblock\HighloadBlockTable; // <--- ДОБАВИТЬ ЭТУ СТРОКУ

define('NO_KEEP_STATISTIC', true);
define('NO_AGENT_STATISTIC', true);
define('NO_AGENT_CHECK', true);
define('PUBLIC_AJAX_MODE', true);
define('DisableEventsCheck', true);

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/api/constants.php';
$request = Context::getCurrent()->getRequest();
$response = [];

// Проверка доступности необходимых модулей
if (!Loader::includeModule('iblock') || !Loader::includeModule('catalog')) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Необходимые модули не установлены'
    ]);
    exit;
}

// Получение параметров запроса
$sectionId = (int)$request->get('section_id');
$sectionCode = $request->get('section_code');

// Получение ID инфоблока каталога товаров
// $catalogIblockId = \CIBlock::GetList([], ['TYPE' => 'catalog', 'ACTIVE' => 'Y'])->Fetch()['ID'];
// $catalogIblockId = 6;
$catalogIblockId = IBLOCK_ID;
if (!$catalogIblockId) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Инфоблок каталога не найден'
    ]);
    exit;
}

// Получение секции каталога или установка фильтра для всех товаров
$sectionData = null;
$priceFilter = [
    'IBLOCK_ID' => $catalogIblockId,
    'ACTIVE' => 'Y',
    'ACTIVE_DATE' => 'Y'
];

if ($sectionId > 0) {
    $sectionData = SectionTable::getRow([
        'filter' => ['ID' => $sectionId, 'IBLOCK_ID' => $catalogIblockId, 'ACTIVE' => 'Y'],
        'select' => ['ID', 'NAME', 'IBLOCK_ID']
    ]);

    if ($sectionData) {
        $priceFilter['SECTION_ID'] = $sectionData['ID'];
        $priceFilter['INCLUDE_SUBSECTIONS'] = 'Y';
    }
} elseif (!empty($sectionCode)) {
    $sectionData = SectionTable::getRow([
        'filter' => ['CODE' => $sectionCode, 'IBLOCK_ID' => $catalogIblockId, 'ACTIVE' => 'Y'],
        'select' => ['ID', 'NAME', 'IBLOCK_ID']
    ]);

    if ($sectionData) {
        $priceFilter['SECTION_ID'] = $sectionData['ID'];
        $priceFilter['INCLUDE_SUBSECTIONS'] = 'Y';
    }
}

// Если секция не найдена и запрошена конкретная секция - возвращаем ошибку
if (($sectionId > 0 || !empty($sectionCode)) && !$sectionData) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Раздел каталога не найден'
    ]);
    exit;
}

// Получение списка свойств товаров для фильтрации
$filterableProperties = [];

// // Получение всех свойств из инфоблока, которые можно использовать в фильтре
// $properties = PropertyTable::getList([
//     'filter' => [
//         'IBLOCK_ID' => $catalogIblockId,
//         'ACTIVE' => 'Y',
//         // 'FILTRABLE' => 'Y'
//     ],
//     'select' => ['ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LIST_TYPE', 'USER_TYPE', 'USER_TYPE_SETTINGS']
// ])->fetchAll();

// 1. Получаем ВСЕ АКТИВНЫЕ свойства инфоблока
$allPropertiesResult = PropertyTable::getList([
    'filter' => [
        'IBLOCK_ID' => $catalogIblockId,
        'ACTIVE' => 'Y',
    ],
    'select' => [ // Выбираем все нужные поля
        'ID',
        'NAME',
        'CODE',
        'PROPERTY_TYPE',
        'MULTIPLE',
        'LIST_TYPE',
        'USER_TYPE',
        'USER_TYPE_SETTINGS'
    ]
]);

$allProperties = [];
while ($prop = $allPropertiesResult->fetch()) {
    $allProperties[$prop['ID']] = $prop; // Сохраняем с ключом по ID для быстрого доступа
}
unset($allPropertiesResult, $prop); // Освобождаем память

// 2. Получаем настройки умного фильтра для свойств в текущем контексте
$sectionIdForLink = $sectionData ? (int)$sectionData['ID'] : 0; // 0 - настройки для инфоблока в целом
$smartFilterSettings = \CIBlockSectionPropertyLink::GetArray($catalogIblockId, $sectionIdForLink);

// 3. Фильтруем свойства, оставляя только те, что отмечены для умного фильтра
$properties = []; // Массив для свойств, которые реально участвуют в умном фильтре
foreach ($allProperties as $propertyId => $property) {
    // Проверяем, есть ли настройка для этого свойства и включен ли SMART_FILTER
    if (isset($smartFilterSettings[$propertyId]) && $smartFilterSettings[$propertyId]['SMART_FILTER'] === 'Y') {
        // Дополнительно можно проверить DISPLAY_TYPE, если нужно отсеять неподдерживаемые
        // Например: if ($smartFilterSettings[$propertyId]['DISPLAY_TYPE'] !== 'U') { ... }

        $properties[] = $property; // Добавляем свойство в итоговый массив
    }
}
unset($allProperties, $smartFilterSettings); // Освобождаем память

// print_r($properties);


// Получение диапазона цен для данного раздела с использованием старого API
$priceMin = 0;
$priceMax = 0;

$basePriceInfo = \CCatalogGroup::GetBaseGroup();
$basePriceId = $basePriceInfo['ID'];

// Получение всех товаров по фильтру
$priceRes = CIBlockElement::GetList(
    [],
    $priceFilter,
    false,
    false,
    ['ID']
);

$productIds = [];
while ($product = $priceRes->Fetch()) {
    $productIds[] = $product['ID'];
}

// Если есть товары, получаем цены
if (!empty($productIds)) {
    // Используем старое API для получения цен
    $pricesRes = CPrice::GetList(
        [],
        [
            'PRODUCT_ID' => $productIds,
            'CATALOG_GROUP_ID' => $basePriceId
        ]
    );

    $prices = [];
    while ($price = $pricesRes->Fetch()) {
        $prices[] = (float)$price['PRICE'];
    }

    if (!empty($prices)) {
        $priceMin = min($prices);
        $priceMax = max($prices);
    }
}

// Добавление ценового фильтра в ответ
$response['price'] = [
    'type' => 'range',
    'name' => 'Цена',
    'code' => 'price',
    'min' => $priceMin,
    'max' => $priceMax,
    'currency' => CurrencyManager::getBaseCurrency()
];



// Получение значений для каждого свойства
foreach ($properties as $property) {
    $propertyValues = [];

    // Если массив ID товаров пуст, переходим к следующему свойству
    if (empty($productIds)) {
        continue;
    }



    switch ($property['PROPERTY_TYPE']) {

        case 'L': // Список

            $propValueRes = CIBlockPropertyEnum::GetList(
                ['SORT' => 'ASC', 'VALUE' => 'ASC'],
                ['PROPERTY_ID' => $property['ID']]
            );

            while ($enumValue = $propValueRes->Fetch()) {
                // Проверяем, используется ли это значение в текущем фильтре
                $elementWithValue = CIBlockElement::GetList(
                    [],
                    array_merge($priceFilter, ['PROPERTY_' . $property['CODE'] => $enumValue['ID']]),
                    false,
                    ['nTopCount' => 1],
                    ['ID']
                );

                if ($elementWithValue->Fetch()) {
                    $propertyValues[] = [
                        'id' => $enumValue['ID'],
                        'value' => $enumValue['VALUE']
                    ];
                }
            }

            if (!empty($propertyValues)) {
                $response['properties'][$property['CODE']] = [
                    'type' => 'list',
                    'name' => $property['NAME'],
                    'code' => $property['CODE'],
                    'multiple' => $property['MULTIPLE'] === 'Y',
                    'values' => $propertyValues
                ];
            }
            break;

        case 'S': // Строка
            if ($property['USER_TYPE'] === 'directory') {

                // print_r($property);
                if (Loader::includeModule('highloadblock')) {


                    // !!! ДОБАВЛЯЕМ ДЕСЕРИАЛИЗАЦИЮ !!!
                    $userTypeSettings = $property['USER_TYPE_SETTINGS'];
                    if (is_string($userTypeSettings) && !empty($userTypeSettings)) {
                        $settingsArray = unserialize($userTypeSettings);
                    } else {
                        // Если это уже массив или что-то другое, пытаемся использовать как есть
                        // или считаем ошибкой
                        $settingsArray = is_array($userTypeSettings) ? $userTypeSettings : null;
                    }

                    // Проверяем, что десериализация прошла успешно и ключ существует
                    if (!is_array($settingsArray) || !isset($settingsArray['TABLE_NAME'])) {
                        error_log("[Filter API Error] Failed to unserialize or find TABLE_NAME in USER_TYPE_SETTINGS for property '{$property['CODE']}'. Raw settings: " . print_r($userTypeSettings, true));
                        continue 2; // Пропускаем это свойство
                    }

                    $tableName = $settingsArray['TABLE_NAME']; // Теперь получаем имя таблицы из массива


                    $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList([
                        'filter' => ['TABLE_NAME' => $tableName]
                    ])->fetch();



                    if ($hlblock) {
                        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
                        $entityDataClass = $entity->getDataClass();

                        // 1. Получаем ВСЕ возможные значения из HL-блока (как и раньше)
                        $allHlValues = [];
                        $hlResult = $entityDataClass::getList([
                            'select' => ['ID', 'UF_NAME', 'UF_XML_ID', 'UF_FILE'],
                            'order' => ['UF_SORT' => 'ASC', 'ID' => 'ASC']
                        ]);
                        while ($hlValue = $hlResult->fetch()) {
                            if (!empty($hlValue['UF_XML_ID']) && is_scalar($hlValue['UF_XML_ID'])) { // Добавил is_scalar
                                $allHlValues[$hlValue['UF_XML_ID']] = $hlValue;
                            }
                        }
                        unset($hlResult);

                        // 2. Получаем ВСЕ значения свойства BRAND_REF из элементов, подходящих под фильтр $priceFilter
                        // БЕЗ группировки, так как свойство множественное
                        $rawUsedXmlIds = []; // Собираем все встретившиеся XML_ID
                        $elementIterator = CIBlockElement::GetList(
                            [], // Сортировка не важна
                            $priceFilter, // Используем основной фильтр раздела/всех товаров
                            false, // БЕЗ ГРУППИРОВКИ
                            false, // Без постранички
                            ['ID', 'PROPERTY_' . $property['CODE']] // Выбираем ID и свойство
                        );

                        while ($element = $elementIterator->Fetch()) {
                            // Для множественного свойства значение должно прийти как массив в _VALUE
                            // Но GetList может вернуть и не массив, если значение одно или пусто
                            $propData = $element['PROPERTY_' . $property['CODE'] . '_VALUE'];

                            if (!empty($propData)) {

                                // Приводим к массиву для унификации обработки
                                if (!is_array($propData)) {
                                    $propData = [$propData];
                                }

                                // Добавляем каждый XML_ID из массива
                                foreach ($propData as $singleXmlId) {
                                    // Проверяем, что это непустое скалярное значение (строка/число)
                                    if (is_scalar($singleXmlId) && trim((string)$singleXmlId) !== '') {
                                        $rawUsedXmlIds[] = $singleXmlId;
                                    }
                                }
                            }
                        }
                        unset($elementIterator); // Освобождаем память

                        // 3. Оставляем только уникальные значения XML_ID
                        // array_flip дважды - быстрый способ получить уникальные значения массива
                        if (!empty($rawUsedXmlIds)) {
                            $uniqueUsedXmlIds = array_keys(array_flip($rawUsedXmlIds));
                        } else {
                            $uniqueUsedXmlIds = [];
                        }


                        // 4. Формируем $propertyValues только для УНИКАЛЬНЫХ ИСПОЛЬЗУЕМЫХ значений
                        // $propertyValues инициализируется в начале цикла по свойствам!
                        foreach ($uniqueUsedXmlIds as $xmlId) {
                            // Ищем информацию об этом значении в ранее полученном списке всех значений
                            if (isset($allHlValues[$xmlId])) {
                                $hlValue = $allHlValues[$xmlId];
                                $fileInfo = [];
                                if (!empty($hlValue['UF_FILE'])) { // Проверка на !empty
                                    $file = CFile::GetFileArray($hlValue['UF_FILE']);
                                    if ($file) {
                                        $fileInfo = [
                                            'src' => $file['SRC'],
                                            'width' => $file['WIDTH'],
                                            'height' => $file['HEIGHT']
                                        ];
                                    }
                                }
                                $propertyValues[] = [
                                    'id' => $hlValue['UF_XML_ID'], // ID для фильтра
                                    'value' => $hlValue['UF_NAME'], // Отображаемое значение
                                    'file' => $fileInfo
                                ];
                            }
                            // Можно добавить логирование, если xmlId используется, но не найден в $allHlValues
                            // else { error_log("Warning: Used XML_ID '{$xmlId}' for property '{$property['CODE']}' not found in HL block."); }
                        }

                        // 5. Добавляем в $response, если что-то нашли
                        if (!empty($propertyValues)) {
                            // Сортировка по названию бренда (опционально)
                            usort($propertyValues, function ($a, $b) {
                                return strnatcasecmp($a['value'], $b['value']);
                            });

                            $response['properties'][$property['CODE']] = [
                                'type' => 'directory', // Тип для фронтенда
                                'name' => $property['NAME'],
                                'code' => $property['CODE'],
                                'multiple' => $property['MULTIPLE'] === 'Y', // true для BRAND_REF
                                'values' => $propertyValues // Используем собранные и отсортированные значения
                            ];
                        }
                    } // end if ($hlblock)
                }
            } else {
                // --- Обычные строковые свойства (оптимизированный вариант) ---

                // Инициализируем массив для сбора уникальных значений ЗДЕСЬ
                $usedValues = [];

                // Используем GetList с группировкой для получения уникальных значений
                $elementIterator = CIBlockElement::GetList(
                    [], // Сортировка не важна
                    array_merge($priceFilter, ['!PROPERTY_' . $property['CODE'] => false]), // Только элементы с заполненным свойством
                    ['PROPERTY_' . $property['CODE']], // Группировка по значению свойства
                    false, // Без пагинации (обычно уникальных значений не так много)
                    ['ID', 'PROPERTY_' . $property['CODE']] // Выбираем ID и значение
                );

                while ($element = $elementIterator->Fetch()) {
                    // Значение свойства (строка)
                    $propValue = $element['PROPERTY_' . $property['CODE'] . '_VALUE'];

                    // Проверяем, что значение не пустое и скалярное (строка или число)
                    if (is_scalar($propValue) && trim((string)$propValue) !== '') {
                        // Используем значение как ключ для автоматической уникальности
                        $usedValues[$propValue] = true;
                    }
                }
                unset($elementIterator); // Освобождаем память

                // Теперь $usedValues содержит уникальные непустые значения как ключи.
                // Проверяем на всякий случай, что это все еще массив (хотя не должно быть иначе)
                if (!is_array($usedValues)) {
                    error_log("[Filter API Error] \$usedValues is not an array for property '{$property['CODE']}' before final processing. Type: " . gettype($usedValues));
                    // Пропускаем добавление значений для этого свойства
                } else {
                    // Преобразуем ключи в нужный формат для ответа
                    // Сортируем значения перед добавлением (опционально, но полезно)
                    $uniqueValues = array_keys($usedValues);
                    natsort($uniqueValues); // Естественная сортировка строк

                    foreach ($uniqueValues as $value) { // Эта строка (~219 в старом коде) теперь должна работать
                        $propertyValues[] = [
                            'id' => $value, // Используем само значение как ID для фильтрации
                            'value' => $value
                        ];
                    }
                }


                // Добавляем в $response, если нашли значения
                if (!empty($propertyValues)) {
                    $response['properties'][$property['CODE']] = [
                        'type' => 'text',
                        'name' => $property['NAME'],
                        'code' => $property['CODE'],
                        'multiple' => $property['MULTIPLE'] === 'Y',
                        'values' => $propertyValues // Используем $propertyValues, собранные выше
                    ];
                }
            }
            break; // Конец case 'S'
        case 'N': // Число
            $propValueRes = CIBlockElement::GetPropertyValues(
                $catalogIblockId,
                $priceFilter,
                true,
                ['ID' => $property['ID']]
            );

            $min = null;
            $max = null;

            while ($values = $propValueRes->Fetch()) {
                if (isset($values[$property['ID']]) && !empty($values[$property['ID']])) {
                    $propValue = $values[$property['ID']];
                    if (is_array($propValue)) {
                        foreach ($propValue as $val) {
                            if (!empty($val)) {
                                $val = (float)$val;
                                if ($min === null || $val < $min) $min = $val;
                                if ($max === null || $val > $max) $max = $val;
                            }
                        }
                    } else {
                        if (!empty($propValue)) {
                            $propValue = (float)$propValue;
                            if ($min === null || $propValue < $min) $min = $propValue;
                            if ($max === null || $propValue > $max) $max = $propValue;
                        }
                    }
                }
            }

            if ($min !== null && $max !== null) {
                $response['properties'][$property['CODE']] = [
                    'type' => 'range',
                    'name' => $property['NAME'],
                    'code' => $property['CODE'],
                    'multiple' => $property['MULTIPLE'] === 'Y',
                    'min' => $min,
                    'max' => $max
                ];
            }
            break;
    }
}

// Добавляем флаг наличия товара
$response['available'] = [
    'type' => 'boolean',
    'name' => 'В наличии',
    'code' => 'available',
    'values' => [
        ['id' => 'Y', 'value' => 'Да'],
        ['id' => 'N', 'value' => 'Нет']
    ]
];

// Финальный ответ
$responseData = [
    'success' => true,
    'filters' => $response
];

// Добавляем информацию о разделе только если он был указан
if ($sectionData) {
    $responseData['section'] = [
        'id' => $sectionData['ID'],
        'name' => $sectionData['NAME']
    ];
} else {
    $responseData['section'] = [
        'id' => 0,
        'name' => 'Все товары'
    ];
}

echo json_encode($responseData);
