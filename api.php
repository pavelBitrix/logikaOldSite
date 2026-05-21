<?php
/**
 * Bitrix REST API entry point — https://api.logika1c.ru
 * Accepts JSON requests from Nuxt frontend
 */

define('NO_KEEP_STATISTIC', true);
define('NO_AGENT_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('STOP_STATISTICS', true);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Logika\Api\Router;

Bitrix\Main\Loader::includeModule('logika.api');

header('Content-Type: application/json; charset=utf-8');

$allowedOrigins = [
    'https://logika1c.ru',
    'https://www.logika1c.ru',
    'http://localhost:3000',
    'http://localhost:3001',
    'http://localhost:8000',
    'http://127.0.0.1:3000',
    'http://127.0.0.1:8000',
    'http://0.0.0.0:8000',
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
// Для удобства dev: разрешаем любой localhost/127/0.0.0.0 на любом порту
if (in_array($origin, $allowedOrigins, true) || preg_match('#^https?://(localhost|127\.0\.0\.1|0\.0\.0\.0)(:\d+)?$#', $origin)) {
    header("Access-Control-Allow-Origin: $origin");
    header('Access-Control-Allow-Credentials: true');
}

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-HTTP-Method-Override');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

try {
    $router = new Router();
    $router->dispatch();
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage(),
    ]);
}
