<?php
// session_start(); 
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit; // preflight
}

// Проверка авторизации
global $USER;

if (!$USER->IsAuthorized()) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Вы не авторизованы',
    ]);
    exit;
}

// Получаем входные данные
$data = json_decode(file_get_contents('php://input'), true);

$oldPassword = trim($data['old_password'] ?? '');
$newPassword = trim($data['new_password'] ?? '');
$confirmPassword = trim($data['confirm_password'] ?? '');

// Проверки
if (!$oldPassword || !$newPassword || !$confirmPassword) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Заполните все поля',
    ]);
    exit;
}

if ($newPassword !== $confirmPassword) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Новый пароль и подтверждение не совпадают',
    ]);
    exit;
}

$userId = $USER->GetID();
$rsUser = CUser::GetByID($userId);
$arUser = $rsUser->Fetch();

// Проверяем старый пароль
$checkUser = new CUser;
$arAuthResult = $checkUser->Login($arUser['LOGIN'], $oldPassword, "N");

if ($arAuthResult !== true && strpos($arAuthResult["MESSAGE"], "успешно") === false) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Старый пароль введён неверно',
    ]);
    exit;
}

// Меняем пароль
$cUser = new CUser;
$update = $cUser->Update($userId, ["PASSWORD" => $newPassword]);

if ($update) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Пароль успешно обновлён',
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => $cUser->LAST_ERROR ?: 'Ошибка при обновлении пароля',
    ]);
}
