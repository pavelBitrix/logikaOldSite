<?php
// local/api/index.php

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_PUBLIC_TOOLS', true);

require_once __DIR__ . '/constants.php';

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

header('Content-Type: application/json');

// Получаем путь из URL
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$path = substr($requestUri, strlen($scriptName));
$path = trim($path, '/');

// Финальный путь на диске
$realPath = $_SERVER['DOCUMENT_ROOT'] . '/local/api/v1/' . $path . '/index.php';

// Проверим, существует ли файл
if (file_exists($realPath)) {
    require $realPath;
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
}
