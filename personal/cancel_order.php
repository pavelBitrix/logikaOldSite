<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Данные аккаунта");
?>		<?
		$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.cancel", 
	"", 
	array(
		"PATH_TO_LIST" => "/personal/",
		"PATH_TO_DETAIL" => "/personal/",
		"SET_TITLE" => "Y",
		"ID" => $ID,
		"COMPONENT_TEMPLATE" => ""
	),
	$component
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>