<?php
ini_set('session.cookie_samesite', 'None');
ini_set('session.cookie_secure', '1'); // Только если у тебя HTTPS, иначе временно можешь поставить 0 для тестов
// session_start(); 
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/cors_header.php";

use Bitrix\Sale;
use Bitrix\Main\Context;
use Bitrix\Currency\CurrencyManager;

if (CModule::IncludeModule('sale') && CModule::IncludeModule('catalog')) {
    
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($productId <= 0 || $quantity <= 0) {
        echo json_encode(["status" => "error", "message" => "Некорректные данные"]);
        die();
    }

    $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Context::getCurrent()->getSite());
    $basketItems = $basket->getBasketItems();

    $item = null;
    foreach ($basketItems as $basketItem) {
        if ($basketItem->getProductId() == $productId) {
            $item = $basketItem;
            break;
        }
    }

    if ($item) {
        // Обновляем количество товара в корзине
        $item->setField('QUANTITY', $item->getQuantity() + $quantity);
    } else {
        // Создаем новый товар в корзине
        $item = $basket->createItem('catalog', $productId);
        $item->setFields([
            'QUANTITY' => $quantity,
            'CURRENCY' => CurrencyManager::getBaseCurrency(),
            'LID' => Context::getCurrent()->getSite(),
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
        ]);
    }

    // Сохраняем изменения
    if ($basket->save()) {
        // Получаем все товары в корзине
        $updatedBasket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Context::getCurrent()->getSite());
        $basketItems = $updatedBasket->getBasketItems();
        
        // Подсчитываем общее количество товаров (без учета их количества)
        $totalItems = 0;
        foreach ($basketItems as $basketItem) {
            if ($basketItem->getQuantity() > 0) {
                $totalItems++;
            }
        }

        echo json_encode([
            "status" => "success",
            "message" => "Товар обновлен/добавлен в корзину",
            "total_items" => $totalItems, // Общее количество разных товаров в корзине
            "FUSERID" => Sale\Fuser::getId(),
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Ошибка при сохранении корзины"]);
    }
}
?>
