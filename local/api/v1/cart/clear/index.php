<?php
// Подключаем Bitrix без вывода HTML - prolog_before достаточно
// session_start(); 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

// Обработка preflight-запроса OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Preflight-запрос успешно обработан, можно завершать скрипт
    exit(0);
}

// --- Проверка метода запроса ---
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['status' => 'error', 'message' => 'Метод не разрешен. Используйте POST.']);
    exit;
}

// --- Основная логика ---
try {
    // Подключаем модуль Sale
    if (!\Bitrix\Main\Loader::includeModule("sale")) {
         // Используем исключения для ошибок
        throw new \Exception("Модуль Sale не найден", 500);
    }

    // Получаем FUSER_ID текущего пользователя (для корзины)
    // CSaleBasket::GetBasketUserID() работает и для авторизованных, и для анонимных
    $fuserId = CSaleBasket::GetBasketUserID(false); // false - не создавать нового FUSER_ID, если его нет

    if (!$fuserId) {
        throw new \Exception("Не удалось определить корзину пользователя (FUSER_ID)", 400); // 400 - Bad Request или другая подходящая ошибка
    }

    // Очищаем корзину для данного FUSER_ID
    // Эта функция удаляет ВСЕ товары пользователя из корзины (не связанные с заказом)
    $result = CSaleBasket::DeleteAll($fuserId, false); // Второй параметр false - не запускать полное пересчитывание корзины немедленно

    // CSaleBasket::DeleteAll обычно не возвращает явного true/false при успехе,
    // но если не было исключений, считаем операцию успешной.
    // Можно добавить более специфичную проверку, если она доступна в вашей версии Bitrix.

    // Отправляем успешный ответ
    echo json_encode(['status' => 'success', 'message' => 'Корзина успешно очищена']);

} catch (\Exception $e) {
    // Обрабатываем возможные ошибки
    // Устанавливаем соответствующий код ответа HTTP
    $statusCode = $e->getCode() >= 400 ? $e->getCode() : 500; // Используем код из Exception или 500 по умолчанию
    http_response_code($statusCode);

    // В продакшене логируйте $e->getMessage() и $e->getTraceAsString() в файл логов Bitrix
    // error_log("Cart Clear Error: " . $e->getMessage());

    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка при очистке корзины: ' . $e->getMessage() // В проде можно вернуть общее сообщение
        // 'detail' => $e->getMessage() // Можно добавить детальное сообщение для отладки
        ]);
}

// Не вызываем epilog_after, так как он может добавить HTML/JS в вывод
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>