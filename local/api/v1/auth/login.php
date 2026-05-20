<?php
/**
 * POST /local/api/v1/auth/login.php
 * Авторизация пользователя. Устанавливает сессию Bitrix (httpOnly cookie).
 *
 * Body: { "email": "...", "password": "..." }
 * Response: { "id": 1, "email": "...", "name": "..." }
 */

require_once __DIR__ . '/../_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    api_error('Метод не поддерживается', 405);
}

$body    = api_body();
$email   = trim($body['email'] ?? '');
$password = $body['password'] ?? '';

if (!$email || !$password) {
    api_error('Email и пароль обязательны', 422);
}

global $USER;
$result = $USER->Login($email, $password, 'N');

if ($result !== true) {
    api_error('Неверный email или пароль', 401);
}

// Bitrix автоматически устанавливает PHPSESSID (httpOnly cookie)
api_response([
    'id'    => (int) $USER->GetID(),
    'email' => $USER->GetEmail(),
    'name'  => $USER->GetFullName(),
    'role'  => $USER->IsAdmin() ? 'admin' : 'user',
]);
