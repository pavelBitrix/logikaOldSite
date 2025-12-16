<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Профиль");
?>
<?if (IsModuleInstalled('sale')):?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.profile.detail",
	"",
	Array(
		"ID" => $ID,
		"PATH_TO_DETAIL" => "",
		"PATH_TO_LIST" => "/personal/",
		"SET_TITLE" => "N",
		"USE_AJAX_LOCATIONS" => "N",
        "USER_CONSENT" => "Y",
        "USER_CONSENT_ID" => "1",
        "USER_CONSENT_IS_CHECKED" => "N",
        "USER_CONSENT_IS_LOADED" => "N",
	)
);?>
<?endif?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>