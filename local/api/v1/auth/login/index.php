<?php
require_once __DIR__ . '/../../_bootstrap.php';

global $USER;
if (!is_object($USER)) $USER = new CUser;

if ($USER->IsAuthorized()) {
    api_error('Пользователь уже авторизован', 400);
}

$data = api_body();
$loginOrEmail = trim($data['email'] ?? $data['login'] ?? '');
$password     = $data['password'] ?? '';

if (!$loginOrEmail || !$password) {
    api_error('Необходимо указать email и пароль');
}

// Если передан email — получаем логин Bitrix
if (filter_var($loginOrEmail, FILTER_VALIDATE_EMAIL)) {
    $rsUser = CUser::GetList(($by = 'id'), ($order = 'asc'), ['=EMAIL' => $loginOrEmail]);
    if (!($arUser = $rsUser->Fetch())) {
        api_error('Пользователь с таким email не найден', 404);
    }
    $login = $arUser['LOGIN'];
} else {
    $login = $loginOrEmail;
}

$authResult = $USER->Login($login, $password, 'Y');

if ($authResult !== true || !$USER->IsAuthorized()) {
    api_error('Неверный логин или пароль', 401);
}

$userData = CUser::GetByID($USER->GetID())->Fetch();

api_response([
    'success' => true,
    'data' => [
        'id'    => (int) $userData['ID'],
        'email' => $userData['EMAIL'],
        'name'  => trim(($userData['NAME'] ?? '') . ' ' . ($userData['LAST_NAME'] ?? '')),
        'phone' => $userData['PERSONAL_PHONE'] ?? '',
    ],
]);
