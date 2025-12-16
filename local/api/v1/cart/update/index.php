<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";
use Bitrix\Main\Context;
use Bitrix\Sale;
use Bitrix\Main\Loader; // Используем Loader для проверки модулей

// Убедимся, что модули подключены
if (!Loader::includeModule('sale') || !Loader::includeModule('catalog')) {
    echo json_encode(["status" => "error", "message" => "Не удалось подключить модули Sale или Catalog"]);
    die();
}

// Проверяем метод запроса (рекомендуется POST или PUT)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
     http_response_code(405); // Method Not Allowed
     echo json_encode(["status" => "error", "message" => "Метод не разрешен. Используйте POST."]);
     die();
}

// Получаем данные из тела запроса (лучше принимать JSON)
$inputData = json_decode(file_get_contents('php://input'), true);

// Или если вы все еще отправляете как form-data:
// $productId = intval($_POST['product_id'] ?? 0);
// $quantity = intval($_POST['quantity'] ?? -1); // Используем -1 как индикатор отсутствия

$productId = intval($inputData['product_id'] ?? 0);
$quantity = intval($inputData['quantity'] ?? -1); // Используем -1 как индикатор отсутствия

// Валидация входных данных
// Количество может быть 0, если мы хотим удалить товар этим методом (хотя лучше отдельный метод для удаления)
// Но пока сделаем, что 0 недопустимо, а для удаления есть removeFromCart
// ИЛИ: можно сделать, что quantity=0 удаляет товар
if ($productId <= 0 || $quantity < 0) { // Разрешаем quantity = 0 для удаления
    echo json_encode([
        "status" => "error",
        "message" => "Некорректные данные: product_id должен быть > 0, quantity >= 0",
        "received_product_id" => $inputData['product_id'] ?? 'не получено',
        "received_quantity" => $inputData['quantity'] ?? 'не получено'
        ]);
    die();
}

try {
    $fuserId = Sale\Fuser::getId();
    if (!$fuserId) {
        // Это может произойти, если сессия истекла или FUser не был создан
         echo json_encode(["status" => "error", "message" => "Не удалось определить пользователя корзины (FUser)."]);
         die();
    }

    $basket = Sale\Basket::loadItemsForFUser($fuserId, Context::getCurrent()->getSite());

    $item = $basket->getExistsItem('catalog', $productId);

    $actionTaken = 'none'; // Для отладки

    if ($item) {
        if ($quantity > 0) {
            // Товар есть, обновляем количество
            $setResult = $item->setField('QUANTITY', $quantity);
            if (!$setResult->isSuccess()) {
                 throw new \Exception("Ошибка установки количества: " . implode("; ", $setResult->getErrorMessages()));
            }
            $actionTaken = 'updated';
        } else { // quantity === 0
            // Товар есть, но количество 0 - удаляем товар
            $deleteResult = $item->delete();
             if (!$deleteResult->isSuccess()) {
                 throw new \Exception("Ошибка удаления товара: " . implode("; ", $deleteResult->getErrorMessages()));
            }
             $actionTaken = 'deleted_due_to_zero_quantity';
        }
    } else {
        // Товара нет в корзине.
        // Теоретически, при обновлении из корзины такого быть не должно.
        // Если quantity > 0, можно было бы добавить товар, но это не соответствует логике "обновления".
        // Лучше вернуть ошибку или ничего не делать.
        if ($quantity > 0) {
            // Можно раскомментировать, если хотите добавлять товар, если его нет
            /*
            $item = $basket->createItem('catalog', $productId);
            $item->setFields([
                'QUANTITY' => $quantity,
                'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                'LID' => Context::getCurrent()->getSite(),
                'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider', // Или ваш провайдер
            ]);
            $actionTaken = 'added_because_not_found';
            */
             echo json_encode([
                "status" => "warning", // Или error
                "message" => "Товар с ID $productId не найден в корзине для обновления.",
                "action" => "none"
            ]);
            die();

        } else {
             // Товара нет и количество 0 - делать нечего
             $actionTaken = 'not_found_and_zero_quantity';
        }
    }

    // Сохраняем изменения в корзине
    $saveResult = $basket->save();

    if ($saveResult->isSuccess()) {
        // Получаем актуальное количество товаров для ответа (опционально)
         $updatedBasket = Sale\Basket::loadItemsForFUser($fuserId, Context::getCurrent()->getSite());
         $totalItemsCount = count($updatedBasket->getBasketItems()); // Количество позиций
         $totalQuantity = $updatedBasket->getQuantityList(); // Суммарное количество всех единиц товара

        echo json_encode([
            "status" => "success",
            "message" => "Количество товара успешно обновлено (действие: $actionTaken)",
            "product_id" => $productId,
            "new_quantity" => $quantity, // Отправляем обратно установленное количество
            "total_items_count" => $totalItemsCount, // Общее число позиций в корзине
            "total_quantity" => array_sum($totalQuantity) // Общее число единиц товаров в корзине
        ]);
    } else {
        throw new \Exception("Ошибка сохранения корзины: " . implode("; ", $saveResult->getErrorMessages()));
    }

} catch (\Exception $e) {
    // Логгирование ошибки важно на продакшене
    // error_log("Cart update error: " . $e->getMessage());
    echo json_encode([
        "status" => "error",
        "message" => "Внутренняя ошибка сервера при обновлении корзины.",
        "details" => $e->getMessage() // Не выводить детали на продакшене!
        ]);
}

?>