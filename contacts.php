<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
$APPLICATION->SetPageProperty("keywords", "1С, бухгалтерия, автоматизация, внедрение, бухгалтерский учет, оперативный учет, курсы 1С, обновление 1С, управленческий учет, Франчайзи, купить 1С, скачать 1С, 1С бухгалтерия, 1С предприятие, 1С зарплата и кадры, 1С кадры, 1С предприятие, 1С расчет, 1С торговля");
$APPLICATION->SetPageProperty("description", "Продажа, установка, настройка программ 1C, обучение пользователей. Разработка и внедрение систем полной автоматизации предприятий.");

$path = '/bitrix/components/bitrix/main.userconsent.request/templates/.default';
\CJSCore::RegisterExt('main_user_consent', Array(
    'js' => $path . '/user_consent.js',
    'css' => $path . '/user_consent.css',
    'lang' => $path . '/user_consent.php',
    'rel' =>   array()
));
CUtil::InitJSCore(array('popup', 'ajax', 'main_user_consent'));
?> 
<section class="title_area">
<div>
	<h1 class="main_title">Контакты</h1>
</div>
 </section> 

<section class="map_area">
<img class="map_contact" src="/bitrix/templates/adaptive_s1/about/map_contact.png" alt=""> 
<div class="map_width">
 <a class="dg-widget-link" href="http://2gis.ru/yakutsk/firm/70000001033391971/center/129.75072383880618,62.03511513143482/zoom/15?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=bigMap">Посмотреть на карте Якутска</a>
<div class="dg-widget-link">
	<a href="http://2gis.ru/yakutsk/firm/70000001033391971/photos/70000001033391971/center/129.75072383880618,62.03511513143482/zoom/17?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=photos">Фотографии компании</a>
</div>
<div class="dg-widget-link">
	<a href="http://2gis.ru/yakutsk/center/129.750345,62.032867/zoom/15/routeTab/rsType/bus/to/129.750345,62.032867╎Логика, бюро автоматизации бизнеса?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=route">Найти проезд до Логика, бюро автоматизации бизнеса</a>
</div>
<script charset="utf-8" src="https://widgets.2gis.com/js/DGWidgetLoader.js"></script><script charset="utf-8">new new DGWidgetLoader({"width":"100%","height":400,"borderColor":"#a3a3a3","pos":{"lat":62.03511513143482,"lon":129.75072383880618,"zoom":15},"opt":{"city":"yakutsk"},"org":[{"id":"70000001033391971"}]});</script> 
</div>
</section>