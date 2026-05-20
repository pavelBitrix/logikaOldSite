<?php
/**
 * Одноразовый скрипт генерации API токена.
 * 1. Загрузи на сервер в ~/public_html/
 * 2. Открой в браузере: http://api.logika1c.ru/generate-token.php
 * 3. Скопируй токен
 * 4. УДАЛИ этот файл с сервера
 */

// Простая защита — чтобы никто случайно не открыл
$secret = $_GET['secret'] ?? '';
if ($secret !== 'logika2026') {
    http_response_code(403);
    die('Forbidden. Add ?secret=logika2026 to URL.');
}

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Config\Option;

$token = bin2hex(random_bytes(32));
Option::set('logika.api', 'api_token', $token);

header('Content-Type: text/plain; charset=utf-8');
echo "=== Logika API Token ===\n\n";
echo $token . "\n\n";
echo "Вставь в Postman: коллекция → Variables → token\n";
echo "Вставь в .env:    BITRIX_API_TOKEN=" . $token . "\n\n";
echo "!!! УДАЛИ ЭТОТ ФАЙЛ С СЕРВЕРА !!!\n";
