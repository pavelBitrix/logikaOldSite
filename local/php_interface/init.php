<?
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.html");
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'onManagerCouponAdd',
    'onManagerCouponAddHandler'
);
function onManagerCouponAddHandler(Bitrix\Main\Event $event)
{
    $couponData = $event->getParameters();
    $event = new Bitrix\Main\Event('sale', "onManagerCouponApply", $couponData);
            //unset($couponData);
            $event->send();
    // try{
    //     \Bitrix\Main\Loader::includeModule('sale');
        
    //     $oBasket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(),\Bitrix\Main\Context::getCurrent()->getSite());
    //     //\Bitrix\Sale\DiscountCouponsManager::init();
    //     \Bitrix\Sale\DiscountCouponsManager::add($couponData['COUPON']);
    //     $oDiscounts = \Bitrix\Sale\Discount::loadByBasket($oBasket);
        
        
        
    //     $oBasket->refreshData(['PRICE', 'COUPONS']);
    //     $oDiscounts->calculate();
    //     $result = $oDiscounts->getApplyResult();
    //     $oBasket->save();
    //     AddMessage2Log("<br/><br/><pre>".print_r($event,true)."</pre><br/><br/>", "test");
    //     //AddMessage2Log("<br/><br/><pre>".print_r($USER->GetID(),true)."</pre><br/><br/>", "test");
        
    //     // $basket = \Bitrix\Sale\BasketBase::loadItemsForFUser($USER->GetID(), $APPLICATION['SITE_ID']);
    //     // if ($couponData["MODULE_ID"]=== "sale") {
    //     //     $dbCoupon = \Bitrix\Sale\Internals\DiscountCouponTable::getList();
    //     //     if ($arCoupon = $dbCoupon->Fetch()) {
    //     //         if ($couponData['COUPON'] == $arCoupon['COUPON']){
                    
    //     //             $arDiscount = CSaleDiscount::GetByID($arCoupon['DISCOUNT_ID']);
                    
    //     //             if($arDiscount['DISCOUNT_TYPE'] == "P"){
    //     //                 AddMessage2Log("<br/><br/><pre>".print_r(123,true)."</pre><br/><br/>", "test");
    //     //                 // $arActions = unserialize($arDiscount['ACTIONS']);
    //     //                 // $arProduct = CCatalogProduct::GetByID($arActions['CHILDREN'][0]['CHILDREN'][0]['DATA']['Value'][0]);
    //     //                 // $dbIBlock = CIBlockElement::GetByID($arActions['CHILDREN'][0]['CHILDREN'][0]['DATA']['Value'][0]);
    //     //                 // $arIBlock= $dbIBlock->GetNext();
    //     //                 // $item = $basket->createItem('catalog',$arActions['CHILDREN'][0]['CHILDREN'][0]['DATA']['Value'][0]);
    //     //                 // $item->setFields(array(
    //     //                 //     'QUANTITY' => 1,
    //     //                 //     'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
    //     //                 //     'LID' => $APPLICATION['LID'],
    //     //                 //     'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
    //     //                 //     'PRICE' => 0,
    //     //                 //     'CUSTOM_PRICE' => 'Y',
    //     //                 // ));
                        
                        
    //     //             }
    //     //             $basket->save();
    //     //         }
    //     //     }
                    
    //     // }
    // } catch (Exception $e){
    //     AddMessage2Log("<br/><br/><pre>".print_r($e,true)."</pre><br/><br/>", "error");
    // }
    
}
    // delete coupon fr om manager
    // if ($result) {
    //     \Bitrix\Sale\DiscountCouponsManager::delete($couponData["COUPON"]);
    // }
    
    
// ── Новый модуль logika.api ─────────────────────────────────────────────────
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;

if (Loader::includeModule('logika.api')) {
    Loader::registerAutoLoadClasses('logika.api', [
        'Logika\Api\Router'                        => 'lib/router.php',
        'Logika\Api\Response'                      => 'lib/response.php',
        'Logika\Api\Auth\TokenAuth'                => 'lib/auth/tokenauth.php',
        'Logika\Api\Controllers\LeadController'    => 'lib/controllers/leadcontroller.php',
        'Logika\Api\Controllers\CatalogController' => 'lib/controllers/catalogcontroller.php',
        'Logika\Api\Controllers\OrderController'   => 'lib/controllers/ordercontroller.php',
        'Logika\Api\Handlers\OneCHandler'          => 'lib/handlers/onechandler.php',
    ]);

    EventManager::getInstance()->addEventHandler(
        'crm',
        'OnAfterCrmLeadAdd',
        ['Logika\Api\Handlers\OneCHandler', 'onLeadCreated']
    );
}