<?php
// Проверяем, что запрос пришел методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    setlocale(LC_TIME, 'ru_RU.UTF-8');
    // Данные для Telegram
    $telegram_token = '7596879766:AAGlaLZjYoCJaOZevvP6Gjq2dOaFzcAxW8U'; // токен бота
    $chat_id = '-4650067665'; // ID группы

       // Получаем ID заявки, если он был передан
    $ticket_id = isset($_POST['ticket_id']) ? htmlspecialchars($_POST['ticket_id']) : null;

    $title = isset($_POST['TITLE']) ? htmlspecialchars($_POST['TITLE']) : 'Не указан';
    $name = isset($_POST['NAME']) ? htmlspecialchars($_POST['NAME']) : 'Не указано';
    $contact = isset($_POST['CONTACT']) ? htmlspecialchars($_POST['CONTACT']) : 'Не указан';
    $description = isset($_POST['DESCRIPTION']) ? htmlspecialchars($_POST['DESCRIPTION']) : 'Нет';

    // Формируем сообщение
    $message = "<b>Новая заявка с сайта logika1c.ru</b>\n\n";

    // Добавляем ID в сообщение, если он есть
    if ($ticket_id) {
        $message .= "<b>ID заявки:</b> <a href='https://logika1c.bitrix24.ru/company/personal/user/165/tasks/task/view/".$ticket_id."/'>" . $ticket_id . "</a>\n";
    }

    $message .= "<b>Тема:</b> " . $title . "\n";
    $message .= "<b>Дата:</b> " . strftime("%d.%m.%Y (%A)") . "\n";
    $message .= "<b>ФИО:</b> " . $name . "\n";
    $message .= "<b>Контакт:</b> " . $contact . "\n";
    $message .= "<b>Комментарий:</b>\n" . $description;

    $url = "https://api.telegram.org/bot" . $telegram_token . "/sendMessage";

    $params = [
        'chat_id' => $chat_id,
        'parse_mode' => 'HTML',
        'text' => $message,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>