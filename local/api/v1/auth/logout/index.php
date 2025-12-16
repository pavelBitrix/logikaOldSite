<?php
// // session_start();
// require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
// require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php"; // УДАЛИТЬ ИЛИ ЗАКОММЕНТИРОВАТЬ
// global $USER;

// if (!$USER->IsAuthorized()) {
//     error_log("Logout attempt by unauthorized user.");
//     echo json_encode(['error' => 'Пользователь не авторизован']);
//     die();
// }

// $userId = $USER->GetID();
// error_log("Attempting logout for user ID: " . $userId);

// $USER->Logout(); // Пытаемся разлогинить пользователя Битрикса

// // Проверяем статус сразу после Logout
// if ($USER->IsAuthorized()) {
//      error_log("User ID: " . $userId . " is STILL authorized after USER->Logout()!");
// } else {
//      error_log("User ID: " . $userId . " successfully logged out by USER->Logout().");
// }

// // Уничтожаем данные сессии на сервере
// error_log("Destroying session ID: " . session_id());
// session_destroy();
// $_SESSION = array(); // Дополнительно очищаем массив
// error_log("Session destroyed.");

// // Принудительно отправляем заголовки для удаления кук в браузере
// $cookieParams = session_get_cookie_params();
// $path = $cookieParams["path"]; // Используем путь из настроек сессии (обычно '/')

// // Удаляем PHPSESSID
// setcookie(session_name(), '', time() - 42000, $path, "", false, true); // Убедитесь, что secure=false для http://localhost
// error_log("Attempted to clear cookie: " . session_name());

// // Удаляем стандартные куки Битрикса (добавьте другие, если нужно)
// setcookie('BITRIX_SM_LOGIN', '', time() - 42000, $path);
// error_log("Attempted to clear cookie: BITRIX_SM_LOGIN");
// setcookie('BITRIX_SM_UIDH', '', time() - 42000, $path);
// error_log("Attempted to clear cookie: BITRIX_SM_UIDH");
// setcookie('BITRIX_SM_SALE_UID', '', time() - 42000, $path);
// error_log("Attempted to clear cookie: BITRIX_SM_SALE_UID");
// // Добавьте другие куки Битрикса, если они используются для авторизации

// echo json_encode(['success' => true, 'message' => 'Выход выполнен успешно']);
// die();


// cors_header.php должен быть здесь, если он НЕ использует функции Битрикса
// require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Если cors_header.php ИСПОЛЬЗУЕТ функции Битрикса, он должен быть ПОСЛЕ prolog_before
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

\Bitrix\Main\Loader::includeModule('sale');

global $USER;

// header("Content-Type: application/json"); // Лучше в cors_header.php

if (!$USER->IsAuthorized()) {
    error_log("Logout attempt by unauthorized user.");
    echo json_encode(['error' => 'Пользователь не авторизован']);
    die();
}

$userId = $USER->GetID();
error_log("Attempting logout for user ID: " . $userId);

// 1. Выход пользователя Битрикс
$USER->Logout();
error_log("USER->Logout() called for user ID: " . $userId);

// 2. Уничтожение PHP сессии (если необходимо)
$sessionName = session_name(); // Обычно PHPSESSID
if (session_status() === PHP_SESSION_ACTIVE) {
    $sessionId = session_id();
    error_log("Destroying session ID: " . $sessionId);
    session_destroy();
    $_SESSION = array();
    error_log("Session destroyed.");
} else {
    error_log("No active PHP session to destroy.");
}

// 3. Принудительная очистка cookies в браузере

// --- Используем ТОЧНЫЕ параметры из вашего вывода ---
$cookie_path    = "/";              // Из данных: Path: /
$cookie_domain  = ".logika1c.ru";   // Из данных: Domain: .logika1c.ru (ВАЖНО: с точкой!)
$cookie_secure  = false;            // Из данных: Secure НЕ установлен
// HttpOnly будет разным для разных кук
// --- Конец настроек параметров ---

$past_time = time() - 3600 * 24 * 30; // Время в прошлом

// Удаляем PHPSESSID (HttpOnly: true)
if (!empty($sessionName)) {
    $cookie_httponly_session = true; // PHPSESSID имеет HttpOnly=true
    setcookie($sessionName, '', $past_time, $cookie_path, $cookie_domain, $cookie_secure, $cookie_httponly_session);
    error_log("Attempting to clear cookie: " . $sessionName . " [Path:{$cookie_path}, Domain:{$cookie_domain}, Secure:{$cookie_secure}, HttpOnly:{$cookie_httponly_session}]");
}

// Удаляем стандартные куки Битрикса
$bitrix_cookies = [
    // Куки с HttpOnly = true
    'BITRIX_SM_LOGIN' => true,
    'BITRIX_SM_UIDH'  => true,
    'BITRIX_SM_UIDL'  => true,
    // Куки с HttpOnly = false (согласно вашим данным)
    'BITRIX_SM_SALE_UID' => false, // <-- Ключевая cookie для FUSERID
    'BITRIX_SM_NCC'      => false, // Тоже не имела галочки HttpOnly
    // Добавьте другие куки, если нужно, указав их HttpOnly статус
    // 'BITRIX_SM_GUEST_ID' => true, // Пример, проверьте реальный статус
    // 'BITRIX_SM_LAST_VISIT' => true, // Пример, проверьте реальный статус
];

foreach ($bitrix_cookies as $cookie_name => $cookie_httponly) {
    error_log("Attempting to clear cookie: " . $cookie_name . " [Path:{$cookie_path}, Domain:{$cookie_domain}, Secure:{$cookie_secure}, HttpOnly:{$cookie_httponly}]");
    setcookie($cookie_name, '', $past_time, $cookie_path, $cookie_domain, $cookie_secure, $cookie_httponly);
}

// Проверка заголовков (для отладки)
$headers_list = headers_list();
error_log("Headers sent for cookie clearing: " . print_r(preg_grep('/^Set-Cookie:/i', $headers_list), true));

// Убедитесь, что Content-Type установлен
if (!headers_sent()) {
     header("Content-Type: application/json");
} else {
     error_log("Headers already sent before setting Content-Type for logout response!");
}

error_log("Logout process finished for user ID: " . $userId);
echo json_encode(['success' => true, 'message' => 'Выход выполнен успешно']);
die();
