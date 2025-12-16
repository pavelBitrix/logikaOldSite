<?php
// Подключаем Bitrix перед выполнением логики
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

use Bitrix\Main\Context;
use Bitrix\Main\UserTable;
use Bitrix\Main\Security\Random;
use Bitrix\Main\Localization\Loc;

// Проверка, если пользователь уже авторизован
global $USER;
// $USER->Logout();
// die();
if ($USER->IsAuthorized()) {
    echo json_encode(['error' => 'Вы уже авторизованы', 'name' => $USER->GetLogin()]);
    die();
}

// Получаем входные параметры из запроса
$data = json_decode(file_get_contents("php://input"), true);  // Чтение JSON данных

$email = $data['email'] ?? null;
$password = $data['password'] ?? null;
$FIO = $data['FIO'] ?? null;
$login = $data['login'] ?? null;

// Проверка на пустые поля
if (!$email || !$password) {
    echo json_encode(['error' => 'Необходимо указать email и пароль']);
    die();
}

// Проверка на уникальность email
$userExists = UserTable::getList([
    'filter' => ['EMAIL' => $email]
])->fetch();

if ($userExists) {
    echo json_encode(['error' => 'Пользователь с таким email уже существует']);
    die();
}

// Генерация уникального логина
// $login = strstr($email, '@', true);

// Генерация пароля для пользователя
$userFields = [
    'NAME' => $FIO,
    'EMAIL' => $email,
    'LOGIN' => $login,
    'PASSWORD' => $password,
    'CONFIRM_PASSWORD' => $password,
    'ACTIVE' => 'Y',
];

// Создание пользователя
$user = new CUser;
$userID = $user->Add($userFields);

if ($userID > 0) {
    // Авторизация после регистрации
    $USER->Authorize($userID);

    echo json_encode(['success' => true, 'user_id' => $userID]);
} else {
    echo json_encode(['error' => 'Ошибка регистрации: ' . $user->LAST_ERROR]);
}

// Подключаем Bitrix завершение
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
