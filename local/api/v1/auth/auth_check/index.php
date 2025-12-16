<?php
// Убедитесь, что session_start() вызывается только один раз,
// если prolog_before.php его уже вызывает, то здесь он не нужен.
// session_start();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";
// НЕ НУЖЕН cors_header.php для same-origin

global $USER;

// Устанавливаем заголовок ответа как JSON
header('Content-Type: application/json');

if ($USER->IsAuthorized()) {
    // Пользователь авторизован, отправляем статус 200 OK
    http_response_code(200);
    echo json_encode([
        'authorized' => true,
        'user' => [ // Возвращаем актуальные данные
            'id' => $USER->GetID(),
            'login' => $USER->GetLogin(),
            'name' => $USER->GetFirstName(),
            'surname' => $USER->GetLastName(), // Используйте GetLastName для фамилии
            'patronymic' => $USER->GetSecondName(), // Используйте GetSecondName для отчества
            'email' => $USER->GetEmail(),
            // Добавьте другие нужные поля
        ]
    ]);
} else {
    // Пользователь НЕ авторизован, отправляем статус 401 Unauthorized
    http_response_code(401);
    echo json_encode([
        'authorized' => false,
        'message' => 'User is not authorized' // Опциональное сообщение
    ]);
}
die();
?>