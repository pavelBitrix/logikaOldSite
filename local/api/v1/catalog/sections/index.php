<?php
// Устанавливаем строгую типизацию для лучшего контроля
declare(strict_types=1);

// Определяем корневую директорию сайта (если файл не в стандартной структуре)
// Подберите правильный путь к document_root вашего сайта
// $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../../../../'); // Примерный путь

// Константа для предотвращения прямого доступа к служебным файлам Битрикса
const NO_KEEP_STATISTIC = true;
const NOT_CHECK_PERMISSIONS = true; // Разрешаем доступ без стандартной проверки прав Битрикса (будет своя логика, если нужна)
const PULL_AJAX_INIT = true;
const LOG_FILENAME = 'php://stderr'; // Вывод ошибок в stderr (удобно для Docker/логирования)

// Подключаем пролог Битрикса для инициализации API
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

// Используем пространства имен Битрикса
use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Bitrix\Main\Web\Json;
use Bitrix\Main\Diag\Debug; // Для отладки
use Bitrix\Iblock;
use Bitrix\Main\IO\Path;
use Bitrix\Main\Application;
use Bitrix\Main\HttpResponse;
use Bitrix\Main\FileTable; // Для получения путей к файлам

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/api/constants.php';

// --- Конфигурация ---
// ID инфоблока каталога - **ВАЖНО**: Замените на ваш ID
// ---------------------
// require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";
header('Content-Type: application/json');
// Обработка OPTIONS запроса для CORS Preflight
if (Context::getCurrent()->getRequest()->getRequestMethod() === 'OPTIONS') {
    // Ничего не делаем, заголовки уже установлены
    die();
}
// -----------------------
$response = Context::getCurrent()->getResponse(); // ← вот это нужно
// --- Основная логика ---
try {
    // Проверяем, подключен ли модуль инфоблоков
    if (!Loader::includeModule('iblock')) {
        throw new \RuntimeException('Iblock module is not installed.', 500);
    }


    // Получаем параметры из запроса
    $request = Context::getCurrent()->getRequest();
    $parentId = $request->getQuery('parent_id'); // ID родительского раздела
    $depthLevel = $request->getQuery('depth_level'); // Конкретный уровень вложенности

    // Валидация и приведение типов параметров
    $parentId = ($parentId !== null && ctype_digit((string)$parentId)) ? (int)$parentId : null;
    $depthLevel = ($depthLevel !== null && ctype_digit((string)$depthLevel)) ? (int)$depthLevel : null;

    // Формируем фильтр для запроса
    $filter = [
        'IBLOCK_ID' => CATALOG_IBLOCK_ID,
        'ACTIVE' => 'Y', // Только активные разделы
        'GLOBAL_ACTIVE' => 'Y', // Только разделы с активными родителями
        // '!DEPTH_LEVEL' => 1 // Пример: исключить корневые разделы, если нужно
    ];

    // Добавляем фильтр по родителю
    if ($parentId !== null) {
        // Если parent_id = 0, ищем корневые разделы
        $filter['SECTION_ID'] = ($parentId === 0) ? false : $parentId;
    }

    // Добавляем фильтр по уровню вложенности
    if ($depthLevel !== null) {
        $filter['DEPTH_LEVEL'] = $depthLevel;
    }





    $sections = [];

    $select = [
        'ID',
        'NAME',
        'CODE', // Символьный код
        'IBLOCK_SECTION_ID', // ID родительского раздела
        'DEPTH_LEVEL', // Уровень вложенности
        'PICTURE', // ID картинки анонса
        'DESCRIPTION', // Описание
        'LEFT_MARGIN', // Для возможной сортировки деревом
        'RIGHT_MARGIN',
        // SECTION_PAGE_URL будет получен отдельно или через runtime поле ниже
    ];

    // Получаем данные о инфоблоке для генерации URL с помощью D7 ORM
    $iblockDataResult = Iblock\IblockTable::getById(CATALOG_IBLOCK_ID);
    $iblockData = $iblockDataResult->fetch(); // Получаем массив с данными инфоблока

    // Проверяем, что инфоблок найден и получаем шаблон URL раздела
    $sectionUrlTemplate = '';
    if ($iblockData && isset($iblockData['SECTION_PAGE_URL'])) {
        $sectionUrlTemplate = $iblockData['SECTION_PAGE_URL']; // В D7 это просто строка шаблона
    } else {
        // Можно добавить логирование или обработку случая, если инфоблок не найден
        // или у него не задан шаблон URL раздела
        // Debug::dumpToFile('Iblock ' . CATALOG_IBLOCK_ID . ' not found or SECTION_PAGE_URL is not set.', '', '/_log/api_error.log');
    }

    $runtimeFields = [];
    // Пример runtime поля для генерации URL (если не нужен стандартный компонент)
    // Обратите внимание: это упрощенный пример, реальная генерация может быть сложнее
    // и использовать CIBlock::ReplaceDetailUrl внутри цикла
    // if ($sectionUrlTemplate) {
    //     $runtimeFields['SECTION_PAGE_URL'] = new \Bitrix\Main\Entity\ExpressionField(
    //         'SECTION_PAGE_URL',
    //         'REPLACE(\''.$sectionUrlTemplate.'\', \'#SECTION_CODE#\', %s)', // Заменяем только #SECTION_CODE# для примера
    //         ['CODE']
    //     );
    //     $select[] = 'SECTION_PAGE_URL'; // Добавляем runtime поле в select
    // }

    $dbSections = Iblock\SectionTable::getList([
        'filter' => $filter,
        'select' => $select,
        // 'runtime' => $runtimeFields,
        'order' => ['SORT' => 'ASC', 'NAME' => 'ASC'], // Стандартная сортировка
    ]);

    $fileIds = [];
    $rawSections = [];
    while ($section = $dbSections->fetch()) {
        // Собираем ID файлов для одного запроса
        if (!empty($section['PICTURE'])) {
            $fileIds[] = $section['PICTURE'];
        }
        // Генерируем URL (более надежный способ, чем runtime)
        $section['SECTION_PAGE_URL'] = \CIBlock::ReplaceDetailUrl(
            $sectionUrlTemplate, // Шаблон URL из настроек инфоблока
            $section,            // Данные раздела
            false,               // Не делать редирект
            'S'                  // Тип элемента - секция
        );

        $rawSections[$section['ID']] = $section;
    }

    // Получаем пути к файлам одним запросом
    $filePaths = [];
    if (!empty($fileIds)) {
        $fileIds = array_unique($fileIds);
        $dbFiles = FileTable::getList([
            'filter' => ['@ID' => $fileIds],
            'select' => ['ID', 'SUBDIR', 'FILE_NAME']
        ]);
        while ($file = $dbFiles->fetch()) {
            $filePaths[$file['ID']] = \CFile::GetPath($file['ID']);
            // Или формируем полный URL, если нужно
            // $filePaths[$file['ID']] = (\Bitrix\Main\Context::getCurrent()->getRequest()->isHttps() ? 'https' : 'http') . '://'
            // . \Bitrix\Main\Context::getCurrent()->getServer()->getHttpHost()
            // . '/upload/' . $file['SUBDIR'] . '/' . $file['FILE_NAME'];
        }
    }



    // Формируем финальный массив секций
    foreach ($rawSections as $section) {
        $sections[] = [
            'id' => (int)$section['ID'],
            'name' => $section['NAME'],
            'code' => $section['CODE'],
            'parentId' => $section['IBLOCK_SECTION_ID'] ? (int)$section['IBLOCK_SECTION_ID'] : null,
            'depthLevel' => (int)$section['DEPTH_LEVEL'],
            'pictureUrl' => $section['PICTURE'] ? ($filePaths[$section['PICTURE']] ?? null) : null,
            'description' => $section['DESCRIPTION'],
            'url' => $section['SECTION_PAGE_URL'],
            // Можно добавить количество активных элементов, но это доп. запрос или runtime поле ELEMENT_CNT
            // 'elementCount' => \CIBlockSection::GetSectionElementsCount($section['ID'], ['CNT_ACTIVE' => 'Y'])
        ];
    }


    // Отправляем успешный ответ
    $response->setStatus(200);
    echo Json::encode([
        'success' => true,
        'data' => $sections,
        'count' => count($sections)
    ]);
} catch (\Throwable $e) {
    // Обработка ошибок
    // Логирование ошибки (пример)
    // Debug::dumpToFile($e->getMessage() . "\n" . $e->getTraceAsString(), "", "/_log/api_error.log");

    // Определяем HTTP статус код
    $statusCode = ($e->getCode() >= 400 && $e->getCode() < 600) ? $e->getCode() : 500;
    $response->setStatus($statusCode);

    // Отправляем ответ с ошибкой
    echo Json::encode([
        'success' => false,
        'error' => [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
            // 'trace' => $e->getTraceAsString() // Включать только в режиме отладки!
        ]
    ]);
} finally {
    // Подключаем эпилог для завершения работы Битрикса (если необходимо)
    // require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');
    // В API часто epilog_after не нужен и может выводить лишнее, можно просто завершить скрипт
    die();
}
