<?php
/**
 * GET /api/v1/auth/me/
 * Возвращает данные текущего авторизованного покупателя.
 * 401 если сессия отсутствует.
 */
require_once __DIR__ . '/../../_bootstrap.php';

$user = api_require_auth();

// Дополняем телефоном из базы (api_current_user не возвращает phone)
$userData = CUser::GetByID($user['id'])->Fetch();

api_response([
    'id'    => $user['id'],
    'email' => $user['email'],
    'name'  => $user['name'],
    'phone' => $userData['PERSONAL_PHONE'] ?? '',
]);
