<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"] . "/bitrix/templates/" . SITE_TEMPLATE_ID . "/header.php");
CJSCore::Init(array("fx"));
?>
<!DOCTYPE html>
<html xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">

<head>
	<title><? $APPLICATION->ShowTitle() ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
	<link rel="icon" type="image/x-icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.ico?v=2" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/swiper/main_slider.css?ver='+Math.random()+">
	<link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/1c/1c.css">
	<link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/quiz.css">
	<link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/swiper/main_slider.css?ver='+Math.random()+">

	<link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/adaptive.css?44">
	<link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/crm/crm.css?ver='+Math.random()+">

	<link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/predpriyatie/predpriyatie.css?ver='+Math.random()+">

	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
	<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 

	<? $APPLICATION->ShowHead(); ?>
	<?$APPLICATION->AddHeadScript("/bitrix/js/main/ajax.js");?>
	<script src="<?= SITE_TEMPLATE_PATH ?>/swiper/jquery.min.js"></script>
</head>

<body class="bx-background-image bx-theme-<?= $theme ?>" <? $APPLICATION->ShowProperty("backgroundImage"); ?>>
	<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>

	<div class="bx-wrapper" id="bx_eshop_wrap">
		<header class="bx-header <? if ($_SERVER['PHP_SELF'] !== '/index.php') { echo 'not-on-homepage'; } ?>">

			<div class="bx-header-section d-flex">
				<!--region bx-header-->
				<div class="d-block d-lg-none bx-menu-button-mobile" data-role='bx-menu-button-mobile-position'></div>
				<div class="bx-header-logo">
					<a class="bx-logo-block d-none d-md-block" href="<?= SITE_DIR ?>">
						<? $APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => SITE_DIR . "include/company_logo.php"
							),
							false
						); ?>
					</a>
					<a class="bx-logo-block d-block d-md-none text-center" href="<?= SITE_DIR ?>">
						<? $APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => SITE_DIR . "include/company_logo_mobile.php"
							),
							false
						); ?>
					</a>
				</div>
				<!--region menu-->
    <? $APPLICATION->IncludeComponent("bitrix:menu", "logika1c_top", array(
	"ROOT_MENU_TYPE" => "top",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_TYPE" => "A",
		"CACHE_SELECTED_ITEMS" => "N",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => "",
		"COMPONENT_TEMPLATE" => "bootstrap_v4",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_THEME" => "site",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
); ?>
				<!--endregion-->
				<div class="bx-header-personal">
					<? $APPLICATION->IncludeComponent(
						"bitrix:sale.basket.basket.line",
						"logika_mobile",
						array(
							"PATH_TO_BASKET" => SITE_DIR . "personal/cart/",	// Страница корзины
							"PATH_TO_PERSONAL" => SITE_DIR . "personal/",	// Страница персонального раздела
							"SHOW_PERSONAL_LINK" => "N",	// Отображать персональный раздел
							"SHOW_NUM_PRODUCTS" => "Y",	// Показывать количество товаров
							"SHOW_TOTAL_PRICE" => "Y",	// Показывать общую сумму по товарам
							"SHOW_PRODUCTS" => "N",	// Показывать список товаров
							"POSITION_FIXED" => "N",	// Отображать корзину поверх шаблона
							"SHOW_AUTHOR" => "Y",	// Добавить возможность авторизации
							"PATH_TO_REGISTER" => SITE_DIR . "login/",	// Страница регистрации
							"PATH_TO_PROFILE" => SITE_DIR . "personal/",	// Страница профиля
							"COMPONENT_TEMPLATE" => ".default_old",
							"PATH_TO_ORDER" => SITE_DIR . "personal/order/make/",	// Страница оформления заказа
							"SHOW_EMPTY_VALUES" => "Y",	// Выводить нулевые значения в пустой корзине
							"PATH_TO_AUTHORIZE" => "",	// Страница авторизации
							"SHOW_REGISTRATION" => "Y",	// Добавить возможность регистрации
							"HIDE_ON_BASKET_PAGES" => "Y",	// Не показывать на страницах корзины и оформления заказа
							"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
							"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
						),
						false
					); ?>
									<a class="header-zayavka" href="/zayavka">
				    Оставить заявку
				    </a>
				</div>
				<!--endregion-->
				
			</div>
		</header>
		<!--region breadcrumb-->
		<main class="main_area <?=($_SERVER['PHP_SELF'] == '/index.php') ? 'on-homepage' : ''?>" id="top">
			<!--endregion-->