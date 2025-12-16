<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
// save_data.php

// Убедитесь, что данные отправлены методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        // Устанавливаем временную зону для Якутска (UTC+9)
        date_default_timezone_set('Asia/Yakutsk');
        // Получаем данные из формы
        $data = [
            'DATE' =>  date('Y-m-d H:i:s'),
            'NAME' => $_POST['NAME'],
            'CONTACT' => $_POST['CONTACT'],
            'TITLE' => $_POST['TITLE'],
            'DESCRIPTION' => $_POST['DESCRIPTION'],
            'FILES' => $_FILES // Если нужно сохранять файлы, обрабатывайте их отдельно
        ];

        // Путь к файлу, где будут храниться данные
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/zayavka/data/backup.json';

        // Проверяем, существует ли файл
        if (file_exists($filePath)) {
            // Читаем существующие данные
            $existingData = json_decode(file_get_contents($filePath), true);
        } else {
            // Если файл не существует, создаем пустой массив
            $existingData = [];
        }

        // Добавляем новые данные в массив
        $existingData[] = $data;

        // Сохраняем данные обратно в файл с указанием кодировки UTF-8
        if (file_put_contents($filePath, json_encode($existingData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) === false) {
            // Если произошла ошибка при записи в файл
            echo json_encode(['status' => 'error', 'message' => 'Failed to write to file'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Отправляем ответ клиенту
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    // Если запрос не POST, возвращаем ошибку
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
