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
    'http://localhost:3000',        // Nuxt dev
    'https://logika1c.ru',          // production frontend
    'https://www.logika1c.ru',
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: $origin");
    header('Access-Control-Allow-Credentials: true');
}

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

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
