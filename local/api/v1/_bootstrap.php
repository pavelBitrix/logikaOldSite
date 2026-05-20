<?php
/**
 * Точка входа для всех API-хендлеров.
 * Подключать первым: require_once __DIR__ . '/../_bootstrap.php';
 */

// ─── Bitrix ядро ─────────────────────────────────────────────────────────────
$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../../../../');
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

// ─── CORS ─────────────────────────────────────────────────────────────────────
$allowedOrigins = [
    'https://logika1c.ru',
    'https://www.logika1c.ru',
    'http://localhost:3000',
    'http://localhost:3001',
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowedOrigins, true)) {
    header('Access-Control-Allow-Origin: ' . $origin);
}
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json; charset=utf-8');

// Preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ─── Хелперы ─────────────────────────────────────────────────────────────────

/**
 * Отдать JSON и завершить скрипт.
 */
function api_response(mixed $data, int $status = 200): never
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    \Bitrix\Main\Application::getInstance()->end();
}

/**
 * Отдать ошибку.
 */
function api_error(string $message, int $status = 400, array $extra = []): never
{
    api_response(['error' => $message, ...$extra], $status);
}

/**
 * Распарсить тело запроса (JSON или form-data).
 */
function api_body(): array
{
    $raw = file_get_contents('php://input');
    if ($raw) {
        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded ?? [];
        }
    }
    return $_POST ?? [];
}

/**
 * Получить текущего авторизованного пользователя через cookie-сессию Bitrix.
 * Возвращает массив с данными пользователя или null.
 */
function api_current_user(): ?array
{
    global $USER;
    if (!$USER || !$USER->IsAuthorized()) {
        return null;
    }
    return [
        'id'    => (int) $USER->GetID(),
        'email' => $USER->GetEmail(),
        'name'  => $USER->GetFullName(),
        'role'  => $USER->IsAdmin() ? 'admin' : 'user',
    ];
}

/**
 * Требовать авторизацию. Если не авторизован — отдать 401 и завершить.
 */
function api_require_auth(): array
{
    $user = api_current_user();
    if (!$user) {
        api_error('Необходима авторизация', 401);
    }
    return $user;
}
