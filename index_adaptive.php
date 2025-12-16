<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetPageProperty("keywords", "1С, бухгалтерия, автоматизация, внедрение, бухгалтерский учет, оперативный учет, курсы 1С, обновление 1С, управленческий учет, Франчайзи, купить 1С, скачать 1С, 1С бухгалтерия, 1С предприятие, 1С зарплата и кадры, 1С кадры, 1С предприятие, 1С расчет, 1С торговля");
$APPLICATION->SetPageProperty("description", "Продажа, установка, настройка программ 1C, обучение пользователей. Разработка и внедрение систем полной автоматизации предприятий.");
$APPLICATION->SetTitle("1C Франчайзи");
$GLOBALS['PRODUCTS_BUSINESS'] = $GLOBALS['SERVICES_BUSINESS'] = array ('PROPERTY_SHOW_ON_MAIN_VALUE' => 'Бизнесу');
$GLOBALS['PRODUCTS_TASKS'] = $GLOBALS['SERVICES_TASK'] = array ('PROPERTY_SHOW_ON_MAIN_VALUE' => 'Задачи');
$GLOBALS['PRODUCTS_GOV'] = $GLOBALS['SERVICES_GOV'] = array ('PROPERTY_SHOW_ON_MAIN_VALUE' => 'Государственным структурам');
$GLOBALS['PRODUCTS_SPHERE'] = $GLOBALS['SERVICES_SPHERE'] = array ('PROPERTY_SHOW_ON_MAIN_VALUE' => 'Отрасли');
$GLOBALS['PRODUCTS_POPULAR'] = $GLOBALS['SERVICES_POPULAR'] = array ('PROPERTY_SHOW_ON_MAIN_VALUE' => 'Популярные продукты');

$path = '/bitrix/components/bitrix/main.userconsent.request/templates/.default';
\CJSCore::RegisterExt('main_user_consent', Array(
    'js' => $path . '/user_consent.js',
    'css' => $path . '/user_consent.css',
    'lang' => $path . '/user_consent.php',
    'rel' =>   array()
));
CUtil::InitJSCore(array('popup', 'ajax', 'main_user_consent'));
?>
<?$APPLICATION->IncludeComponent("bitrix:news.list", "banners", Array(
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "#banners_IBLOCK_ID#",
		"NEWS_COUNT" => "7",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER2" => "DESC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => "",
		"PROPERTY_CODE" => array(
			0 => "DETAIL_LINK",
			1 => "TEXT_LINK",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AUTO_SCROLL" => 'Y',
		"AUTO_SCROLL_TIME" => '3',
	),
	false
);?>
	<div class="about-product">
		<div class="tab-wrapper" data-wrapper="tab">
			<ul class="tab-menu-list" data-wrapper="tab-action">
				<li class="tab-menu-item" data-action="tab" data-id="business">Бизнесу</li>
				<li class="tab-menu-item" data-action="tab" data-id="gos">Государственным структурам</li>
				<li class="tab-menu-item" data-action="tab" data-id="industry">Отрасли</li>
				<li class="tab-menu-item" data-action="tab" data-id="tasks">Задачи</li>
				<li class="tab-menu-item" data-action="tab" data-id="products">Популярные продукты</li>
			</ul>
			<div class="tab-block-list">
				<div class="tab-block-item" data-item="tab" data-id="business">
					<div class="tab-block-head" data-action="tab">Бизнесу</div>
					<div class="tab-block-body" data-description="tab">
						<div class="tab-block-content">
							<div class="column-wrapper">
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"main_products",
									array(
										"COMPONENT_TEMPLATE" => "",
										"IBLOCK_TYPE" => "news",
										"IBLOCK_ID" => "#catalog_IBLOCK_ID#",
										"NEWS_COUNT" => "6",
										"SORT_BY1" => "ACTIVE_FROM",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "PRODUCTS_BUSINESS",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => ""
									),
									false
								);?>
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"main_services",
									array(
										"COMPONENT_TEMPLATE" => "",
										"IBLOCK_TYPE" => "news",
										"IBLOCK_ID" => "#SERVICES_BLOCK_ID#",
										"NEWS_COUNT" => "4",
										"SORT_BY1" => "ACTIVE_FROM",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "SERVICES_BUSINESS",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "/service/common/#ELEMENT_CODE#/",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => ""
									),
									false
								);?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-block-item" data-item="tab" data-id="gos">
					<div class="tab-block-head" data-action="tab">Гос. структурам</div>
					<div class="tab-block-body" data-description="tab">
						<div class="tab-block-content">
							<div class="column-wrapper">
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"main_products",
									array(
										"COMPONENT_TEMPLATE" => "",
										"IBLOCK_TYPE" => "news",
										"IBLOCK_ID" => "#catalog_IBLOCK_ID#",
										"NEWS_COUNT" => "6",
										"SORT_BY1" => "ACTIVE_FROM",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "PRODUCTS_GOV",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => ""
									),
									false
								);?>
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"main_services",
									array(
										"COMPONENT_TEMPLATE" => "",
										"IBLOCK_TYPE" => "news",
										"IBLOCK_ID" => "#SERVICES_BLOCK_ID#",
										"NEWS_COUNT" => "4",
										"SORT_BY1" => "ACTIVE_FROM",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "SERVICES_GOV",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "/service/common/#ELEMENT_CODE#/",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => ""
									),
									false
								);?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-block-item" data-item="tab" data-id="industry">
					<div class="tab-block-head" data-action="tab">Отрасли</div>
					<div class="tab-block-body" data-description="tab">
						<div class="tab-block-content">
							<div class="column-wrapper">
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"main_products",
									array(
										"COMPONENT_TEMPLATE" => "",
										"IBLOCK_TYPE" => "news",
										"IBLOCK_ID" => "#catalog_bx_IBLOCK_ID#",
										"NEWS_COUNT" => "6",
										"SORT_BY1" => "ACTIVE_FROM",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "PRODUCTS_SPHERE",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => ""
									),
									false
								);?>
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"main_services",
									array(
										"COMPONENT_TEMPLATE" => "",
										"IBLOCK_TYPE" => "news",
										"IBLOCK_ID" => "#SERVICES_BLOCK_ID#",
										"NEWS_COUNT" => "4",
										"SORT_BY1" => "ACTIVE_FROM",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "SERVICES_SPHERE",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "/service/common/#ELEMENT_CODE#/",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => ""
									),
									false
								);?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-block-item" data-item="tab" data-id="tasks">
					<div class="tab-block-head" data-action="tab">Задачи</div>
					<div class="tab-block-body" data-description="tab">
						<div class="tab-block-content">
							<div class="column-wrapper">
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"main_products",
									array(
										"COMPONENT_TEMPLATE" => "",
										"IBLOCK_TYPE" => "news",
										"IBLOCK_ID" => "#catalog_IBLOCK_ID#",
										"NEWS_COUNT" => "6",
										"SORT_BY1" => "ACTIVE_FROM",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "PRODUCTS_TASKS",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => ""
									),
									false
								);?>
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"main_services",
									array(
										"COMPONENT_TEMPLATE" => "",
										"IBLOCK_TYPE" => "news",
										"IBLOCK_ID" => "#SERVICES_BLOCK_ID#",
										"NEWS_COUNT" => "4",
										"SORT_BY1" => "ACTIVE_FROM",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "SERVICES_TASKS",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "/service/common/#ELEMENT_CODE#/",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => ""
									),
									false
								);?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-block-item" data-item="tab" data-id="products">
					<div class="tab-block-head" data-action="tab">Популярные продукты</div>
					<div class="tab-block-body" data-description="tab">
						<div class="tab-block-content">
							<div class="column-wrapper">
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"main_products",
									array(
										"COMPONENT_TEMPLATE" => "",
										"IBLOCK_TYPE" => "news",
										"IBLOCK_ID" => "#catalog_IBLOCK_ID#",
										"NEWS_COUNT" => "6",
										"SORT_BY1" => "ACTIVE_FROM",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "PRODUCTS_POPULAR",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => ""
									),
									false
								);?>
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.list",
									"main_services",
									array(
										"COMPONENT_TEMPLATE" => "",
										"IBLOCK_TYPE" => "news",
										"IBLOCK_ID" => "#SERVICES_BLOCK_ID#",
										"NEWS_COUNT" => "4",
										"SORT_BY1" => "ACTIVE_FROM",
										"SORT_ORDER1" => "DESC",
										"SORT_BY2" => "SORT",
										"SORT_ORDER2" => "ASC",
										"FILTER_NAME" => "SERVICES_POPULAR",
										"FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "",
										),
										"CHECK_DATES" => "Y",
										"DETAIL_URL" => "/service/common/#ELEMENT_CODE#/",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"CACHE_TYPE" => "A",
										"CACHE_TIME" => "36000000",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "Y",
										"PREVIEW_TRUNCATE_LEN" => "",
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"SET_TITLE" => "N",
										"SET_BROWSER_TITLE" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_LAST_MODIFIED" => "N",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"HIDE_LINK_WHEN_NO_DETAIL" => "N",
										"PARENT_SECTION" => "",
										"PARENT_SECTION_CODE" => "",
										"INCLUDE_SUBSECTIONS" => "Y",
										"DISPLAY_DATE" => "Y",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"PAGER_TEMPLATE" => ".default",
										"DISPLAY_TOP_PAGER" => "N",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"PAGER_TITLE" => "",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"SET_STATUS_404" => "N",
										"SHOW_404" => "N",
										"MESSAGE_404" => ""
									),
									false
								);?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!--.about-product-->

<?if (IsModuleInstalled('advertising')):?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:advertising.banner",
		"main_wide",
		array(
			"COMPONENT_TEMPLATE" => ".default",
			"TYPE" => "MAIN_WIDE",
			"NOINDEX" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "0"
		),
		false
	);?>
<?else:?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"banner_wide",
		array(
			"COMPONENT_TEMPLATE" => "",
			"IBLOCK_TYPE" => "news",
			"IBLOCK_ID" => "#banners_long_IBLOCK_ID#",
			"NEWS_COUNT" => "10",
			"SORT_BY1" => "ACTIVE_FROM",
			"SORT_ORDER1" => "DESC",
			"SORT_BY2" => "SORT",
			"SORT_ORDER2" => "ASC",
			"FILTER_NAME" => "",
			"FIELD_CODE" => array(
				0 => "DETAIL_PICTURE",
				1 => "",
			),
			"PROPERTY_CODE" => array(
				0 => "LINK",
				1 => "CSS",
			),
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "N",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"PREVIEW_TRUNCATE_LEN" => "",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"SET_TITLE" => "N",
			"SET_BROWSER_TITLE" => "N",
			"SET_META_KEYWORDS" => "N",
			"SET_META_DESCRIPTION" => "N",
			"SET_LAST_MODIFIED" => "N",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"INCLUDE_SUBSECTIONS" => "Y",
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"PAGER_TEMPLATE" => ".default",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"PAGER_TITLE" => "",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"SET_STATUS_404" => "N",
			"SHOW_404" => "N",
			"MESSAGE_404" => ""
		),
		false
	);?>
<?endif;?>

<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"main_news",
	array(
		"COMPONENT_TEMPLATE" => "",
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "#NEWS_BLOCK_ID#",
		"NEWS_COUNT" => "3",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "DETAIL_PICTURE",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>

	<div class="partners">
		<div class="header-2 partners-title">Более 6 500 организаций и частных лиц<br>уже сотрудничают с нами</div>
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"clients",
			array(
				"COMPONENT_TEMPLATE" => "",
				"IBLOCK_TYPE" => "works",
				"IBLOCK_ID" => "#CLIENTS_IBLOCK_ID#",
				"NEWS_COUNT" => "10",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "",
				"FIELD_CODE" => array(
					0 => "DETAIL_PICTURE",
					1 => "",
				),
				"PROPERTY_CODE" => array(
					0 => "",
					1 => "",
				),
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_LAST_MODIFIED" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"INCLUDE_SUBSECTIONS" => "Y",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"PAGER_TEMPLATE" => ".default",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => ""
			),
			false
		);?>
		<a href="/projects/" class="btn-icon-inline">Внедрённые решения</a>
	</div><!-- /.partners -->

	<div class="column-wrapper info-block-wrapper">
		<?if (IsModuleInstalled('advertising')):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:advertising.banner",
				"main_top",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"TYPE" => "MAIN_TOP",
					"NOINDEX" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "0",
            		"QUANTITY" => "2"
				),
				false
			);?>
		<?else:?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"banner_small",
				array(
				"COMPONENT_TEMPLATE" => "",
				"IBLOCK_TYPE" => "news",
				"IBLOCK_ID" => "#banners_small_IBLOCK_ID#",
				"NEWS_COUNT" => "10",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "",
				"FIELD_CODE" => array(
				0 => "DETAIL_PICTURE",
				1 => "",
				),
				"PROPERTY_CODE" => array(
					0 => "LINK",
					1 => "CSS",
				),
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_LAST_MODIFIED" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"INCLUDE_SUBSECTIONS" => "Y",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"PAGER_TEMPLATE" => ".default",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => ""
				),
				false
			);?>
		<?endif;?>
	</div><!--.column-wrapper info-block-wrapper-->

	<div class="about-company">
		<h3 class="header-2">О компании</h3>
		<div class="company-description">
			<p>Наша компания занимается автоматизацией управления и учёта на базе программных продуктов «1С» с 1997 года. За последние 10 лет произведено около  8015 поставок программных продуктов 1C, в том числе более 1741 программ собственной разработки — 1С: Совместимо.</p>
		</div>
		<div class="simple-carousel-wrapper about-company-carousel-wrapper">
			<div class="simple-carousel" data-mobile-carousel>
				<div>
					<div class="about-company-slide">
						<span class="about-company-number">2500</span> <span class="about-company-text">Выполненных<br>проектов</span>
					</div>
				</div><!--обертка для slick-->
				<div>
					<div class="about-company-slide about-company-slide2">
						<span class="about-company-number">6</span> <span class="about-company-text2">Лет опыта</span>
					</div>
				</div><!--обертка для slick-->
				<div>
					<div class="about-company-slide">
						<span class="about-company-number">80<sub>%</sub></span> <span class="about-company-text">Повторных <br>обращений</span>
					</div>
				</div><!--обертка для slick-->
			</div>
			<div class="simple-carousel-btn prev" data-mobile-carousel-prev></div>
			<div class="simple-carousel-btn next" data-mobile-carousel-next></div>
		</div><!-- /. -->
		<div class="page-content">
			<ul class="list-column-2">
				<li>Нам доверяют крупные компании Чувашии.</li>
				<li>В нашей компании работают сертифицированные фирмой «1С» специалисты, которые постоянно совершенствуют свои знания и навыки. Количество сертификатов  54.</li>
				<li>
					В 2004 году мы стали Центром Технического Обслуживания (ЦТО) контрольно-кассовой техники и весов. Количество обслуживаемого оборудования составляет 1019 единиц.e
					<br><br>
				</li>
				<li>С 2011 года мы успешно развиваем новое направление — бухгалтерское обслуживание предприятий (бухгалтерский аутсорсинг).</li>
				<li>Мы всегда предлагаем лучшее качество услуг за разумные деньги.</li>
			</ul>

		</div><!--.page-content-->
		<div class="contacts-block">
			<div class="column-wrapper">
				<div class="column column-5 column-tablet-6" data-item="form" data-url="{request:/form/?WEB_FORM_ID=#FORM_request#&USER_CONSENT=Y&USER_CONSENT_ID=1&USER_CONSENT_IS_CHECKED=N&USER_CONSENT_IS_LOADED=N">
					Есть вопросы? <a href="#" data-type="request" data-action="form" >Напишите нам</a><br>
					или позвоните по бесплатному телефону
				</div>
				<div class="column column-6 column-tablet-6">
					<a href="tel:88002501860" class="contact-number">8-800-250-18-60</a>
				</div>
			</div>
		</div><!-- /.contacts-block -->
	</div><!-- /.about-company -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>