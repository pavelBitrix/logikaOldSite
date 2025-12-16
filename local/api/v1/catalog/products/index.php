<?php

/**
 * API Эндпоинт для получения списка товаров с базовой фильтрацией.
 *
 * Параметры:
 * - priceFrom (float): Минимальная цена
 * - priceTo (float): Максимальная цена
 * - Любые другие параметры будут интерпретированы как фильтры по свойствам
 *   в формате PROPERTY_{GET_PARAMETER_KEY} = GET_PARAMETER_VALUE
 *   Например: ?MANUFACTURER=SomeValue -> фильтр по PROPERTY_MANUFACTURER = "SomeValue"
 *            ?COLOR[]=Red&COLOR[]=Blue -> фильтр по PROPERTY_COLOR = ["Red", "Blue"] (ИЛИ)
 */

// Подключение Bitrix (пролог без визуальной части)
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Используем D7 Json для корректной работы с UTF-8
use Bitrix\Main\Web\Json;

require_once $_SERVER['DOCUMENT_ROOT']. '/local/api/constants.php';

// --- Конфигурация ---
// --------------------
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";
// header('Content-Type: application/json');


// Если это OPTIONS запрос (предварительный запрос CORS), сразу завершаем выполнение
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Проверка подключения модулей
if (!CModule::IncludeModule("catalog") || !CModule::IncludeModule("iblock")) {
    echo Json::encode(['success' => false, 'error' => 'Required modules (catalog, iblock) not installed']);
    die();
}

// --- Получение и обработка параметров запроса ---
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$queryParams = $request->getQueryList()->toArray(); // Получаем все GET-параметры

$priceFrom = isset($queryParams['priceFrom']) && is_numeric($queryParams['priceFrom']) ? (float)$queryParams['priceFrom'] : null;
$priceTo = isset($queryParams['priceTo']) && is_numeric($queryParams['priceTo']) ? (float)$queryParams['priceTo'] : null;

// --- Формирование основного фильтра ---
$arFilter = [
    "IBLOCK_ID" => IBLOCK_ID,
    "ACTIVE" => "Y",        // Только активные товары
    "ACTIVE_DATE" => "Y",   // Актуальные по дате
    // "CATALOG_AVAILABLE" => "Y" // Раскомментируйте, если нужны только доступные к покупке
];


// $res = CIBlockElement::GetList(
//     [], 
//     ["IBLOCK_ID" => IBLOCK_ID, "ACTIVE" => "Y"], 
//     false, 
//     ["nTopCount" => 5], 
//     ["ID", "NAME", "PROPERTY_*"]
// );

// for ($i=0; $i < 1; $i++) { 
//     if ($item = $res->GetNext()) {
//         echo "<pre>"; print_r($item); echo "</pre>";
//     }
// }

// $res = CIBlockElement::GetList(
//     [],
//     ["IBLOCK_ID" => IBLOCK_ID, "ACTIVE" => "Y"],
//     false,
//     ["nTopCount" => 1],
//     ["ID", "NAME", "PROPERTY_SHIRINA_CHEKA"]
// );

// while ($ob = $res->GetNextElement()) {
//     $item = $ob->GetFields();      // Основные поля элемента
//     $props = $ob->GetProperties(); // Все свойства, включая списочные

//     echo "<pre>"; print_r($item); echo "</pre>";
//     echo "<pre>"; print_r($props); echo "</pre>";
// }


// Добавляем фильтр по цене
if ($priceFrom !== null) {
    $arFilter[">=CATALOG_PRICE_" . PRICE_CODE_ID] = max(0, $priceFrom);
}
if ($priceTo !== null) {
    $arFilter["<=CATALOG_PRICE_" . PRICE_CODE_ID] = max(0, $priceTo);
}

// --- Добавление динамических фильтров по свойствам ---
$propertySelectFields = []; // Массив для сбора кодов свойств, чтобы добавить их в $arSelect
foreach ($queryParams as $key => $value) {
    // Пропускаем уже обработанные параметры и пустые значения
    if (in_array(strtolower($key), ['pricefrom', 'priceto']) || $value === '' || $value === null) {
        continue;
    }

    $propertyCode = strtoupper($key); // Приводим к верхнему регистру (должно совпадать с кодом свойства в Битрикс)

    // // Проверяем, если свойство "Список", то ищем его ENUM_ID
    $dbEnum = CIBlockPropertyEnum::GetList([], ["IBLOCK_ID" => IBLOCK_ID, "CODE" => $propertyCode, "VALUE" => $value]);
    if ($enum = $dbEnum->Fetch()) {
        $arFilter["PROPERTY_" . $propertyCode] = $enum["ID"]; // Фильтруем по ENUM_ID
    } else {
        $arFilter["PROPERTY_" . $propertyCode] = $value; // Обычный фильтр для строк и чисел
    }
    // Проверяем, является ли свойство списком (ENUM)
    // $propertyRes = CIBlockProperty::GetList([], ["IBLOCK_ID" => IBLOCK_ID, "CODE" => $propertyCode]);
    // if ($property = $propertyRes->Fetch()) {
    //     if ($property["PROPERTY_TYPE"] === "L") { // L - список (ENUM)
    //         $dbEnum = CIBlockPropertyEnum::GetList([], ["IBLOCK_ID" => IBLOCK_ID, "CODE" => $propertyCode, "ID" => $value]);
    //         if ($enum = $dbEnum->Fetch()) {
    //             $arFilter["=PROPERTY_" . $propertyCode] = $enum["ID"]; // Фильтр по ID ENUM
    //         }
    //     } else {
    //         $arFilter["=PROPERTY_" . $propertyCode] = $value; // Фильтр для обычных свойств
    //     }
    // }

    $propertySelectFields[] = "PROPERTY_" . $propertyCode;
}

// --- Формирование полей для выборки ---
$arSelect = [
    "ID",
    "IBLOCK_ID",
    "NAME",
    "CODE", // Символьный код элемента
    "DETAIL_PICTURE",
    "DETAIL_PAGE_URL", // Получаем готовый URL
    "CATALOG_PRICE_" . PRICE_CODE_ID, // Выбираем базовую цену
    "CATALOG_CURRENCY_" . PRICE_CODE_ID, // Валюта базовой цены
    "CATALOG_AVAILABLE", // Доступность товара (Y/N) - надежнее, чем количество
    // Добавляем сюда стандартные свойства, которые нужны всегда (если есть)
    // "PROPERTY_ARTICLE",
    // "PROPERTY_BRAND"
];

// print_r($propertySelectFields);

// Добавляем динамически запрошенные свойства в выборку (убираем дубликаты)
$arSelect = array_merge($arSelect, array_unique($propertySelectFields));

// print_r($arSelect);
// print_r($arFilter);

// --- Выполнение запроса GetList ---
$res = CIBlockElement::GetList(
    ["SORT" => "ASC", "ID" => "DESC"], // Сортировка по умолчанию
    $arFilter,                         // Собранный фильтр
    false,                             // Не группировать
    false,                             // Без пагинации (выбираем все)
    $arSelect                          // Собранные поля для выборки
);

// --- Обработка результатов ---
$products = [];
$fileIds = [];
$rawItems = [];



// Используем GetNextElement для более удобного доступа к свойствам,
// особенно множественным и сложным (хотя ваш метод тоже рабочий)
while ($obElement = $res->GetNextElement()) {
    $item = $obElement->GetFields(); // Получаем основные поля
    // Получаем ВСЕ свойства в удобном формате ['CODE' => ['NAME' => ..., 'VALUE' => ..., 'PROPERTY_VALUE_ID' => ...]]
    $item['PROPERTIES'] = $obElement->GetProperties();

    $itemId = (int)$item['ID'];
    if (!empty($item['DETAIL_PICTURE'])) {
        $fileIds[] = (int)$item['DETAIL_PICTURE'];
    }
    $rawItems[$itemId] = $item; // Сохраняем элемент с полями и свойствами
}

// Получаем пути к картинкам одним запросом (если есть товары)
$filePaths = [];
if (!empty($fileIds)) {
    $fileIds = array_unique($fileIds);
    $dbFiles = CFile::GetList([], ["@ID" => implode(',', $fileIds)]);
    while ($file = $dbFiles->Fetch()) {
        $filePaths[$file['ID']] = '/upload/' . $file['SUBDIR'] . '/' . $file['FILE_NAME']; // Формируем относительный путь
    }
}

// Форматируем финальный массив товаров
foreach ($rawItems as $id => $item) {
    $productProperties = [];
    // Собираем значения свойств из полученных полей PROPERTY_*
    foreach ($item as $key => $value) {
        if (strpos($key, 'PROPERTY_') === 0 && $key !== 'PROPERTY_VALUES' && $value !== null && $value !== false) {
            // Извлекаем чистый код свойства
            $propCode = str_replace(['PROPERTY_', '_VALUE', '_ENUM_ID', '_DESCRIPTION'], '', $key);
            // Если для этого кода свойства еще нет записи, создаем ее
            if (!isset($productProperties[$propCode])) {
                $productProperties[$propCode] = ['code' => $propCode, 'value' => null];
            }
            // Сохраняем значение (учитываем VALUE_ENUM_ID и DESCRIPTION, если они выбраны)
            if (strpos($key, '_VALUE') !== false || strpos($key, '_ENUM_ID') === false && strpos($key, '_DESCRIPTION') === false) {
                $productProperties[$propCode]['value'] = $item['~' . $key] ?? $value; // Используем ~ для HTML сущностей
            } elseif (strpos($key, '_ENUM_ID') !== false) {
                $productProperties[$propCode]['enum_id'] = $value;
            } elseif (strpos($key, '_DESCRIPTION') !== false) {
                $productProperties[$propCode]['description'] = $item['~' . $key] ?? $value;
            }
        }
    }
    // Преобразуем в простой массив значений свойств
    $formattedProperties = array_values($productProperties);


    $products[] = [
        'id' => (int)$item['ID'],
        'name' => $item['~NAME'] ?? $item['NAME'], // Используем ~NAME для защиты от HTML
        'code' => $item['CODE'] ?? null,
        'quantity' => $item['CATALOG_QUANTITY'] ?? null,
        'url' => $item['DETAIL_PAGE_URL'] ?? null,
        'price' => isset($item['CATALOG_PRICE_' . PRICE_CODE_ID]) ? (float)$item['CATALOG_PRICE_' . PRICE_CODE_ID] : null,
        'currency' => $item['CATALOG_CURRENCY_' . PRICE_CODE_ID] ?? null,
        'pictureUrl' => $item['DETAIL_PICTURE'] ?  ($filePaths[(int)$item['DETAIL_PICTURE']] ?? null) : null,
        'available' => ($item['CATALOG_AVAILABLE'] ?? 'N') === 'Y',
        'properties' => $formattedProperties, // Массив со свойствами товара
    ];
}

// --- Отправка данных в формате JSON ---
echo Json::encode(['success' => true, 'data' => $products], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

// Завершаем выполнение скрипта (старый стиль, как в примере)
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
