<?php
// session_start(); 
// Подключаем пролог Bitrix перед любым выводом
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

// --- Подключение модулей Bitrix ---
use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Bitrix\Main\Application; // Добавлено для получения контекста
use Bitrix\Currency\CurrencyManager;
use Bitrix\Sale\Order;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Delivery\Services\Manager as DeliveryManager;
use Bitrix\Sale\PaySystem\Manager as PaySystemManager;
use Bitrix\Sale\PaySystem\Service as PaySystemService; // Добавлено для работы с платежной системой

// Проверяем, подключены ли необходимые модули
if (!Loader::includeModule("sale") || !Loader::includeModule("currency")) {
    echo json_encode(['status' => 'error', 'message' => 'Не удалось подключить модули Sale или Currency']);
    exit;
}

// --- Авторизация пользователя ---
global $USER;
$userId = $USER->GetID();
if (!$userId) {
    // Устанавливаем статус 401 Unauthorized
    http_response_code(401);
    echo json_encode(['status' => 'error', 'userId' => $userId, 'message' => 'Пользователь не авторизован']);
    exit;
}

// --- Получение данных запроса ---
$request = Context::getCurrent()->getRequest();
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'status' => 'error',
        'message' => 'Некорректные данные заказа. Ожидается JSON.',
        'json_error' => json_last_error_msg()
    ]);
    exit;
}

// --- Работа с корзиной ---
$fUserId = \CSaleBasket::GetBasketUserID();
$basket = Basket::loadItemsForFUser($fUserId, SITE_ID);

if ($basket->isEmpty()) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Корзина пуста']);
    exit;
}

// --- Создание и настройка заказа ---
$order = Order::create(SITE_ID, $userId);
$order->setPersonTypeId(1); // Убедитесь, что тип плательщика 1 существует и подходит
$order->setBasket($basket);
$order->setField("CURRENCY", CurrencyManager::getBaseCurrency());

// Добавляем доставку (если указана)
$shipment = null; // Инициализируем переменную
if (!empty($data['deliveryMethod'])) {
    $deliveryId = intval($data['deliveryMethod']);
    $deliveryService = DeliveryManager::getObjectById($deliveryId);
    if ($deliveryService) {
        $shipmentCollection = $order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem($deliveryService);
        $shipmentItemCollection = $shipment->getShipmentItemCollection();

        /** @var Bitrix\Sale\BasketItem $basketItem */
        foreach ($basket as $basketItem) {
            $item = $shipmentItemCollection->createItem($basketItem);
            $item->setQuantity($basketItem->getQuantity());
        }
        // Устанавливаем стоимость доставки, если она рассчитывается
        // $shipment->setField('BASE_PRICE_DELIVERY', $calculatedDeliveryPrice); // Пример
        // $shipment->setField('PRICE_DELIVERY', $calculatedDeliveryPrice);
    } else {
        // Можно вернуть ошибку, если указан несуществующий ID доставки
        // http_response_code(400);
        // echo json_encode(['status' => 'error', 'message' => 'Указанный метод доставки не найден']);
        // exit;
    }
}

// Добавляем оплату (если указана)
$payment = null; // Инициализируем переменную
$paymentId = !empty($data['paymentMethod']) ? intval($data['paymentMethod']) : null;
if ($paymentId) {
    $paySystemObject = PaySystemManager::getObjectById($paymentId);
    if ($paySystemObject) {
        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem($paySystemObject);
        // Сумма оплаты будет установлена ниже, после расчета итоговой стоимости
    } else {
        // Можно вернуть ошибку, если указан несуществующий ID оплаты
        // http_response_code(400);
        // echo json_encode(['status' => 'error', 'message' => 'Указанный метод оплаты не найден']);
        // exit;
    }
}

// Устанавливаем свойства заказа
$propertyCollection = $order->getPropertyCollection();
$fieldsMap = [
    "FIO" => "name",
    "EMAIL" => "email",
    "PHONE" => "phone",
    "ADDRESS" => "address", // Пример свойства адреса
    "ZIP" => "zip"         // Пример свойства индекса
];

foreach ($fieldsMap as $bitrixCode => $jsonKey) {
    if (isset($data[$jsonKey])) { // Проверяем isset, чтобы обработать и пустые строки
        $property = $propertyCollection->getItemByOrderPropertyCode($bitrixCode);
        if ($property) {
            $property->setValue(htmlspecialchars(trim($data[$jsonKey])));
        } else {
            // Логирование или обработка ситуации, если свойство с кодом не найдено
            // error_log("Свойство заказа с кодом '$bitrixCode' не найдено.");
        }
    }
}

// Добавляем комментарий к заказу
if (!empty($data['comments'])) {
    $order->setField("USER_DESCRIPTION", htmlspecialchars(trim($data['comments'])));
}

// --- Расчет и установка итоговой стоимости ---
// Пересчитываем стоимость с учетом доставки (если она была добавлена и имеет стоимость)
// Важно: этот refresh должен быть вызван ДО установки суммы в платежную систему
$refreshResult = $order->refreshData(['PRICE', 'PRICE_DELIVERY', 'SUM_PAID', 'DISCOUNT_PRICE']);
if (!$refreshResult->isSuccess()) {
    error_log("Ошибка при обновлении данных заказа: " . implode(", ", $refreshResult->getErrorMessages()));
    // Возможно, стоит прервать выполнение и вернуть ошибку
}

$totalPrice = $order->getPrice(); // Получаем итоговую стоимость заказа ПОСЛЕ refreshData

// Устанавливаем сумму для созданного объекта оплаты (если он есть)
if ($payment) {
    $payment->setField("SUM", $totalPrice);
    $payment->setField("CURRENCY", $order->getCurrency());
}


// --- Сохранение заказа ---
$saveResult = $order->save();

if (!$saveResult->isSuccess()) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка при сохранении заказа',
        'details' => $saveResult->getErrorMessages()
    ]);
} else {
    // --- Заказ успешно сохранен, получаем ID ---
    $orderId = $order->getId();
    $paymentUrl = null; // Инициализируем URL оплаты

    // --- Получение ссылки на оплату (ПОСЛЕ сохранения заказа) ---
    // Перезагружаем коллекцию оплат, чтобы получить актуальные данные
    $savedPaymentCollection = $order->getPaymentCollection();

    /** @var \Bitrix\Sale\Payment $savedPayment */
    foreach ($savedPaymentCollection as $savedPayment) {
        // Проверяем, что оплата не оплачена и есть ID платежной системы
        if (!$savedPayment->isPaid() && $savedPayment->getPaymentSystemId() > 0) {
            $paySystemService = PaySystemManager::getObjectById($savedPayment->getPaymentSystemId());

            if ($paySystemService) {
                $context = Application::getInstance()->getContext();
                $paymentUrl = null;
                $paymentHtml = null;
                $initResult = null;      // Инициализируем явно
                $bufferedOutput = '';  // Для хранения вывода из буфера

                error_log("DEBUG Order {$orderId}: Включаем буферизацию вывода перед initiatePay.");
                ob_start(); // <<<=== НАЧИНАЕМ БУФЕРИЗАЦИЮ

                try {
                    // Вызываем метод, который может напрямую выводить HTML
                    $initResult = $paySystemService->initiatePay($savedPayment, $context->getRequest());
                } catch (\Exception $e) {
                    // Ловим возможные исключения во время initiatePay
                    error_log("DEBUG Order {$orderId}: Исключение во время initiatePay: " . $e->getMessage() . "\n" . $e->getTraceAsString());
                    // Можно установить флаг ошибки или обработать иначе
                } finally {
                    // Получаем всё, что было выведено в буфер во время initiatePay
                    $bufferedOutput = ob_get_contents(); // <<<=== ЗАБИРАЕМ ВЫВОД ИЗ БУФЕРА

                    // Очищаем буфер и выключаем буферизацию
                    ob_end_clean(); // <<<=== ЗАВЕРШАЕМ БУФЕРИЗАЦИЮ

                    error_log("DEBUG Order {$orderId}: Буферизация вывода завершена. Длина буфера: " . strlen($bufferedOutput));
                    if (!empty($bufferedOutput)) {
                        // Логируем начало буферизированного вывода для проверки
                        error_log("DEBUG Order {$orderId}: Содержимое буфера (первые 500 символов): " . substr(htmlspecialchars($bufferedOutput), 0, 500));
                    }
                }


                // --- ТЕПЕРЬ АНАЛИЗИРУЕМ РЕЗУЛЬТАТЫ ---

                // 1. ПРИОРИТЕТ: Если что-то было выведено напрямую в буфер (и это похоже на HTML форму)
                // Проверяем наличие тега <form, чтобы убедиться, что это не просто текст ошибки
                if (!empty($bufferedOutput) && stripos($bufferedOutput, '<form') !== false) {
                    $paymentHtml = $bufferedOutput; // Используем захваченный HTML
                    error_log("DEBUG Order {$orderId}: Используем HTML из буфера вывода.");
                }
                // 2. ЕСЛИ БУФЕР ПУСТ ИЛИ НЕ СОДЕРЖИТ ФОРМУ: Проверяем объект $initResult (если он был создан)
                elseif ($initResult instanceof \Bitrix\Sale\PaySystem\ServiceResult) {
                    error_log("DEBUG Order {$orderId}: initiatePay вернул объект ServiceResult. Успех: " . ($initResult->isSuccess() ? 'Да' : 'Нет'));

                    if ($initResult->isSuccess()) {
                        $resultData = [];
                        if (method_exists($initResult, 'getData')) {
                            $resultData = $initResult->getData();
                            if (!is_array($resultData)) {
                                $resultData = [];
                            }
                            error_log("DEBUG Order {$orderId}: Данные из ServiceResult->getData(): " . print_r($resultData, true));
                        }

                        // Пытаемся получить HTML или URL стандартными методами ServiceResult
                        if (method_exists($initResult, 'getTemplate') && ($htmlContent = $initResult->getTemplate())) {
                            $paymentHtml = $htmlContent; // Берем HTML из getTemplate
                            error_log("DEBUG Order {$orderId}: Используем HTML из getTemplate().");
                        } elseif (method_exists($initResult, 'getPaymentUrl') && ($url = $initResult->getPaymentUrl())) {
                            $paymentUrl = $url; // Берем URL из getPaymentUrl
                            error_log("DEBUG Order {$orderId}: Используем URL из getPaymentUrl().");
                        } elseif (!empty($resultData['TEMPLATE'])) { // Проверяем данные из getData()
                            $paymentHtml = $resultData['TEMPLATE'];
                            error_log("DEBUG Order {$orderId}: Используем HTML из getData()['TEMPLATE'].");
                        } elseif (!empty($resultData['PAYMENT_URL'])) {
                            $paymentUrl = $resultData['PAYMENT_URL'];
                            error_log("DEBUG Order {$orderId}: Используем URL из getData()['PAYMENT_URL'].");
                        } // Добавьте другие проверки getData(), если нужно
                        else {
                            error_log("Order {$orderId}: ServiceResult успешен, но не найден HTML/URL стандартными методами или в getData().");
                        }
                    } else {
                        // $initResult вернул неуспех
                        error_log("Order {$orderId}: ServiceResult от initiatePay вернул ошибку: " . implode(", ", $initResult->getErrorMessages()));
                    }
                } else {
                    // Сценарий, когда буфер пуст (или не содержит форму), И $initResult не является объектом ServiceResult
                    error_log("Order {$orderId}: initiatePay не вернул корректный ServiceResult, и в буфере не было HTML формы. Вероятно, инициация платежа не удалась.");
                    // Можно установить общее сообщение об ошибке для ответа JSON, если нужно
                    // $response['error_message'] = 'Не удалось инициировать платеж.';
                }
            } else {
                // $paySystemService был null
                error_log("DEBUG Order {$orderId}: \$paySystemService был null для PaySystem ID " . $savedPayment->getPaymentSystemId());
            }
        }
    } // Конец цикла по оплатам

    // --- Формирование успешного ответа ---
    $response = [
        'status' => 'success',
        'message' => 'Заказ успешно оформлен',
        'order_id' => $orderId,
        'total_price' => $totalPrice,
    ];

    // Добавляем URL ИЛИ HTML оплаты в ответ
    if ($paymentUrl) {
        $response['payment_url'] = $paymentUrl;
    } elseif ($paymentHtml) {
        // Используем другое имя ключа для HTML, чтобы фронтенд мог их различить
        $response['payment_html'] = $paymentHtml;
    }

    http_response_code(201); // Created


    echo json_encode($response);

    // Очищаем корзину пользователя ПОСЛЕ успешного оформления заказа
    \CSaleBasket::DeleteAll(\CSaleBasket::GetBasketUserID());
} // Конец блока успешного сохранения

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); // Подключаем эпилог