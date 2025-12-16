<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetPageProperty("keywords", "1С, бухгалтерия, автоматизация, внедрение, бухгалтерский учет, оперативный учет, курсы 1С, обновление 1С, управленческий учет, Франчайзи, купить 1С, скачать 1С, 1С бухгалтерия, 1С предприятие, 1С зарплата и кадры, 1С кадры, 1С предприятие, 1С расчет, 1С торговля");
$APPLICATION->SetPageProperty("description", "Продажа, установка, настройка программ 1C, обучение пользователей. Разработка и внедрение систем полной автоматизации предприятий.");
$APPLICATION->SetTitle("Бюро автоматизации бизнеса ООО Логика");
$GLOBALS['PRODUCTS_BUSINESS'] = $GLOBALS['SERVICES_BUSINESS'] = array('PROPERTY_SHOW_ON_MAIN_VALUE' => 'Бизнесу');
$GLOBALS['PRODUCTS_TASKS'] = $GLOBALS['SERVICES_TASK'] = array('PROPERTY_SHOW_ON_MAIN_VALUE' => 'Задачи');
$GLOBALS['PRODUCTS_GOV'] = $GLOBALS['SERVICES_GOV'] = array('PROPERTY_SHOW_ON_MAIN_VALUE' => 'Государственным структурам');
$GLOBALS['PRODUCTS_SPHERE'] = $GLOBALS['SERVICES_SPHERE'] = array('PROPERTY_SHOW_ON_MAIN_VALUE' => 'Отрасли');
$GLOBALS['PRODUCTS_POPULAR'] = $GLOBALS['SERVICES_POPULAR'] = array('PROPERTY_SHOW_ON_MAIN_VALUE' => 'Популярные продукты');

$path = '/bitrix/components/bitrix/main.userconsent.request/templates/.default';
\CJSCore::RegisterExt('main_user_consent', array(
	'js' => $path . '/user_consent.js',
	'css' => $path . '/user_consent.css',
	'lang' => $path . '/user_consent.php',
	'rel' =>   array()
));
CUtil::InitJSCore(array('popup', 'ajax', 'main_user_consent'));
?>
 <section class="lgk-area row">
<div class="col lgk-area-text">
	<h1>РАЗВИВАЕМ БИЗНЕС ВМЕСТЕ С ВАМИ</h1>
	<h2>
	ООО "Логика" -&nbsp;это аккредитованная компания и официальный партнер фирмы «1С», которая специализируется на автоматизации бизнеса на территории Якутии с 2018 года.</h2>
	<h2 class="title-text"> <a href="/zayavka" class="lgk-btn">
	оставить заявку</a> </h2>
</div>
 </section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>