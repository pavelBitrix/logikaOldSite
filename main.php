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
?><section class="lgk-area row">
<div class="col lgk-area-text">
	<h1>РАЗВИВАЕМ БИЗНЕС ВМЕСТЕ С ВАМИ</h1>
	<h2>
	ООО "Логика" - лидер по поставкам программных продуктов 1С и торгового оборудования в г. Якутске. За 13 лет развития компании, мы прошли путь от рядовой настройки программных продуктов до лидера на рынке. Нам доверяют тысячи клиентов. </h2>
	<h2 class="title-text"> <a href="/zayavka" class="lgk-btn">
	оставить заявку</a> </h2>
</div>
<div class="swiper swiper-cards col-4">
	<div class="swiper-wrapper slide-area">
		<div class="swiper-slide slide-area">
 <img src="<?php echo SITE_TEMPLATE_PATH ?>/slider/bit24.png" alt=""><span>CRM Bitrix24</span>
		</div>
		<div class="swiper-slide slide-area">
 <img src="<?php echo SITE_TEMPLATE_PATH ?>/slider/1c.png" alt=""><span>1C:Предприятие</span>
		</div>
		<div class="swiper-slide slide-area">
 <img src="<?php echo SITE_TEMPLATE_PATH ?>/slider/buxg.png" alt=""><span>Бухобслуживание</span>
		</div>
		<div class="swiper-slide slide-area">
 <img src="<?php echo SITE_TEMPLATE_PATH ?>/slider/web.png" alt=""><span>Web-разработка</span>
		</div>
	</div>
</div>
 </section>
<div class="page_content">
	<h2 class="title-text">Услуги</h2>
	<div>
		<div class="competencies-wrap">
			<div class="grid-container grid-container--2">
				<div class="lgk-grid">
 <a href="/crm.php" class="competencies bgBitrix" id="competencies1">
					<div class="competencies__info">
						<h4>CRM Bitrix 24</h4>
						<p>
							 Битpикc24 помогает бизнесу работать Вместо десятков сервисов и приложений — единая платформа для организации работы всей компании.
						</p>
					</div>
 </a>
				</div>
				<div class="lgk-grid">
 <a href="/predpriyatie.php" class="competencies bgOneC" id="competencies2">
					<div class="competencies__info">
						<h4>1C: Предприятие</h4>
						<p>
							 — эффективное управление, учет и документооборот более чем в 1 500 000 организаций
						</p>
					</div>
 </a>
				</div>
				<div class="lgk-grid">
 <a href="/1c.php" class="competencies bgBux" id="competencies3">
					<div class="competencies__info">
						<h4>Бухобслуживание</h4>
						<p>
							 — сеть партнеров фирмы "1C", оказывающих услуги по ведению бухгалтерского, налогового, кадрового учета и расчета заработной платы малому бизнесу по единому стандарту
						</p>
					</div>
 </a>
				</div>
				<div class="lgk-grid">
 <a href="/site.php" class="competencies bgWeb" id="competencies4">
					<div class="competencies__info">
						<h4>Web-разработка</h4>
						<p>
							 Наша компания занимается созданием сайтов любой сложности, стоимости и тематики
						</p>
					</div>
 </a>
				</div>
			</div>
		</div>
	</div>
 <section class="section">
	<div class="section__head text-animation__default text-animation__block">
		<h2 class="title-text">Каталог</h2>
	</div>
			  <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top", 
	"logika1c", 
	array(
		"COMPONENT_TEMPLATE" => "logika1c",
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => "53",
		"FILTER_NAME" => "",
		"HIDE_NOT_AVAILABLE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ELEMENT_COUNT" => "4",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"VIEW_MODE" => "SECTION",
		"TEMPLATE_THEME" => "blue",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false}]",
		"ENLARGE_PRODUCT" => "STRICT",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Под заказ",
		"MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
		"SECTION_URL" => "catalog/#SECTION_CODE#/",
		"DETAIL_URL" => "catalog/#SECTION_CODE#/#ELEMENT_CODE#/",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"SEF_MODE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "N",
		"CACHE_FILTER" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRICE_CODE" => array(
			0 => "Продажа по розничным ценам",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"ADD_TO_BASKET_ACTION" => "ADD",
		"DISPLAY_COMPARE" => "N",
		"MESS_BTN_COMPARE" => "Сравнить",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"COMPATIBLE_MODE" => "N",
		"ROTATE_TIMER" => "30",
		"SHOW_PAGINATION" => "Y",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"OR\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBSection\",\"DATA\":{\"logic\":\"Equal\",\"value\":241}},{\"CLASS_ID\":\"CondIBSection\",\"DATA\":{\"logic\":\"Equal\",\"value\":202}}]}",
		"PROPERTY_CODE_MOBILE" => array(
		),
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => array(
		),
		"SEF_RULE" => ""
	),
	false
);?>
	<div>
	</div>
 <a class="catalog_btn" href="/catalog/">Смотреть каталог</a>
 </section> 
    <div class="placeholder"></div>
<h2 class="title-text">О нас </h2>
 <div class="row">
  <div class="col-12 col-md-8 about-panel">
      <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/about/consult.png" alt="">
      <h3>Проконсультируем и установим оборудование для Вашего бизнеса</h3>
  </div>
</div>
 <div class="row">
  <div class="col-6 col-md-4"></div>
    <div class="col-12 col-md-8 about-panel"> 
     <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/about/system.png" alt="">
    <h3>Подберем и установим внедрим учетную систему</h3>
   </div>
</div>

 <div class="row">
  <div class="col-12 col-md-8 about-panel">
      <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/about/expert.png" alt="">
      <h3>Окажем квалифицированную поддержку</h3>
  </div>
</div>
 <div class="row">
  <div class="col-6 col-md-4"></div>
    <div class="col-12 col-md-8 about-panel"> 
     <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/about/developer.png" alt="">
    <h3>Разработаем сайт</h3>
   </div>
</div>

 <div class="row">
  <div class="col-12 col-md-8 about-panel">
      <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/about/crm.png" alt="">
      <h3>Внедрим CRM-систему</h3>
  </div>
</div>
 <div class="row">
  <div class="col-6 col-md-4"></div>
    <div class="col-12 col-md-8 about-panel"> 
     <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/about/designer.png" alt="">
    <h3>Разработаем индивидуальный дизайн</h3>
   </div>
</div>

	<!--<section class="section">--> <!--	<div class="section__head text-animation__default text-animation__block">--> <!--		<h2 class="title">Наши партнеры</h2>--> <!--	</div>--> <!--	<div class="swiper swiper-container">--> <!--		<div class="swiper-wrapper">--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/2.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/3.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/4.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/5.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/1.png" alt=""> </div>--> <!--		</div>--> <!--	</div>--> <!--	<div class="swiper swiper-container2">--> <!--		<div class="swiper-wrapper">--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/6.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/7.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/8.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/10.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/9.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/17.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/18.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/19.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/16.png" alt=""> </div>--> <!--		</div>--> <!--	</div>--> <!--	<div class="swiper swiper-container3">--> <!--		<div class="swiper-wrapper">--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/11.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/12.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/13.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/14.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/15.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/20.png" alt=""> </div>--> <!--			<div class="swiper-slide"><img src="/bitrix/templates/eshop_bootstrap_v4/images/partners/21.png" alt=""> </div>--> <!--		</div>--> <!--	</div>--> <!--</section>--> 
<h2 class="title-text">Публикации</h2>	
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"logika1c", 
	array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DETAIL_URL" => "/posts/index.php?ELEMENT_ID=#ELEMENT_ID#",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "DATE_ACTIVE_FROM",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "news",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "4",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "logika1c",
		"TEMPLATE_THEME" => "blue",
		"MEDIA_PROPERTY" => "",
		"SLIDER_PROPERTY" => "",
		"SEARCH_PAGE" => "/search/",
		"USE_RATING" => "N",
		"USE_SHARE" => "N"
	),
	false
);?>	
<h2 class="title-text">Вендоры</h2>
  <div class="row vendors">
    <a class="col" target="_blank" href="https://www.atol.ru/">
       <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/atol.png" alt="">
       <h2>Атол<h2>
       <h4>IT-компания, ведущий российский производитель оборудования и разработчик программного обеспечения для автоматизации таких сфер как ритейл, e-commerce, услуги, включая HoReCa, транспорт, ЖКХ и многое другое.  </h4>   
    </a>
    <a class="col" target="_blank" href="https://mertech.ru/">
     <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/mertech.png" alt="">
        <h2>MERTECH®<h2>
       <h4>Торговая марка компании зарегистрирована более 20 лет назад. Родиной бренда является Южная Корея. За 20 лет развития компании, техника МЕ® заслуженно получила мировую известность. </h4>   
    </a>
  </div>
  <div class="row vendors">
    <a class="col" target="_blank" href="https://evotor.ru/">
       <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/evator.png" alt="">
        <h2>Эвото́р<h2>
       <h4>Российская ИТ-компания, производитель «умных» онлайн-касс и программного обеспечения. По собственным данным компании, доля «Эвотора» на рынке онлайн-касс в сегменте малого и микробизнеса составляет 25 %. </h4>   
    </a>
    <a class="col" target="_blank" href="https://1c.ru/">
      <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/vendor1c.png" alt="">
        <h2>1С<h2>
       <h4>Программа для построения на предприятии единой информационной системы, охватывающей основные задачи управления и учета. Данное решение позволяет автоматизировать важнейшие области бизнеса: бухгалтерию, торговлю, склад, расчет зарплаты, кадровый учет. </h4>   
    </a>
    <a class="col" target="_blank" href="https://platformaofd.ru/">
      <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/ofd.png" alt="">
        <h2>Платформа ОФД <br> (ООО «Эвотор ОФД»)<h2>
       <h4>№1 на рынке и крупнейший оператор фискальных данных России*, оператор электронного документооборота и отчетности. Аккредитованный партнер системы маркировки товаров (ЦРПТ). </h4>   
    </a>
  </div>
</div>
<br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>