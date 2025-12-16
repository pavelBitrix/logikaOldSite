<?php

// session_start([
//     // Опционально: Явно задать параметры куки сессии
//     // 'cookie_lifetime' => 0, // До закрытия браузера
//     // 'cookie_path' => '/',
//     // 'cookie_domain' => '.yourdomain.com', // Общий домен, если нужно
//     // 'cookie_secure' => true, // Если HTTPS
//     // 'cookie_httponly' => true,
//     // 'cookie_samesite' => 'None' // Если HTTPS и cross-site
// ]);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

if ($USER->IsAuthorized()) {
    echo json_encode(['error' => 'Пользователь уже авторизован']);
    die();
}

global $USER;
if (!is_object($USER)) $USER = new CUser;

// Уже авторизован
if ($USER->IsAuthorized()) {
    echo json_encode(['error' => 'Пользователь уже авторизован']);
    die();
}

// Получение и валидация входных данных
$data = json_decode(file_get_contents("php://input"), true);
$loginOrEmail = $data['email'] ?? null;
$password = $data['password'] ?? null;

if (!$loginOrEmail || !$password) {
    echo json_encode(['error' => 'Необходимо указать логин/email и пароль']);
    die();
}

// Проверяем: email или логин
$isEmail = filter_var($loginOrEmail, FILTER_VALIDATE_EMAIL);

// Если email — получаем логин
if ($isEmail) {
    $rsUser = CUser::GetList(
        ($by = "id"),
        ($order = "asc"),
        ['=EMAIL' => $loginOrEmail]
    );
    if ($arUser = $rsUser->Fetch()) {
        $login = $arUser['LOGIN'];
    } else {
        echo json_encode(['error' => 'Пользователь с таким email не найден']);
        die();
    }
} else {
    $login = $loginOrEmail;
}

// Авторизация
$arAuthResult = $USER->Login($login, $password, "Y");

if ($arAuthResult === true && $USER->IsAuthorized()) {
    $userData = CUser::GetByID($USER->GetID())->Fetch();

    $token = 'jwt-token-' . time();

    echo json_encode([
        'success' => true,
        'message' => 'Авторизация прошла успешно',
        'data' => [
            'token' => $token,
            'user' => [
                'id' => (int) $userData['ID'],
                'name' => $userData['NAME'],
                'surname' => $userData['LAST_NAME'],
                'patronymic' => $userData['SECOND_NAME'],
                'email' => $userData['EMAIL'],
                'lastLogin' => $userData['LAST_LOGIN'], // можно заменить на date('c') если нужно текущее время
            ],
        ],
    ]);
} else {
    echo json_encode(['error' => 'Неверный логин/email или пароль']);
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
