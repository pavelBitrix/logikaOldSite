<?php
// $allowed_origin = 'https://vue.logika1c.ru'; // Ваш фронтенд

// // Разрешить preflight-запросы
// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     header("Access-Control-Allow-Origin: $allowed_origin");
//     header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
//     header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
//     header("Access-Control-Allow-Credentials: true");
//     exit(0); // Обязательно выйти
// }

// // Основной заголовок для других запросов
// header("Access-Control-Allow-Origin: $allowed_origin");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
// header("Access-Control-Allow-Credentials: true");
// header("Content-Type: application/json");

// 1. Определите ВСЕ разрешенные источники
$allowed_origins = [
    'https://logika1c.ru',
    'https://www.logika1c.ru',
    'https://vue.logika1c.ru',
    'http://localhost:3000',
    'http://localhost:3001',
    'http://localhost:8000',
    'http://127.0.0.1:8000',
    'http://localhost:5173',
    'http://127.0.0.1:5173',
    'http://localhost:5174',
    'http://127.0.0.1:5174',
];

// 2. Получите источник запроса
$request_origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : null;

// 3. Проверьте и установите заголовки
if ($request_origin && in_array($request_origin, $allowed_origins)) {
    $origin_to_allow = $request_origin;

    // Preflight (OPTIONS)
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header("Access-Control-Allow-Origin: " . $origin_to_allow);
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400");
        exit(0);
    }

    // Другие запросы (GET, POST...)
    header("Access-Control-Allow-Origin: " . $origin_to_allow);
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json"); // Устанавливайте Content-Type здесь или позже, перед выводом JSON

} else {
    // Источник не разрешен - не отправляем заголовок Allow-Origin
    // Можно добавить логирование или явный ответ об ошибке
    header("Content-Type: application/json"); // Все равно установим, если планируем JSON-ошибку
    // http_response_code(403);
    // echo json_encode(['error' => 'Origin not allowed']);
    // exit; // Выйти, если отправили ответ об ошибке
}

// --- Дальше идет ваш основной код PHP на хостинге ---
// подключение к БД, обработка запроса и т.д.

?>