<?php
// Включаем Bitrix ядро
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define("BX_BUFFER_USED", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Разрешаем CORS, если нужно (добавь свой cors_header.php, если есть)
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

// Отвечаем на preflight-запрос
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

// header('Content-Type: application/json');

// Получаем email из JSON тела
$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Некорректный E-mail',
    ]);
    exit;
}

// Проверяем, существует ли пользователь с таким email
$filter = ['=EMAIL' => $email];
$rsUser = \CUser::GetList(($by = "id"), ($order = "desc"), $filter);
if ($arUser = $rsUser->Fetch()) {
    $userLogin = $arUser['LOGIN'];

    // Пытаемся отправить письмо восстановления
    $result = \CUser::SendPassword($userLogin, $email);

    if ($result['TYPE'] === 'OK') {
        echo json_encode([
            'status' => 'success',
            'message' => 'Ссылка для восстановления отправлена на почту',
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => $result['MESSAGE'] ?? 'Ошибка при отправке письма',
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Пользователь с таким email не найден',
    ]);
}
?>