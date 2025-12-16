<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Склады");
?><div style="margin-left: 20%">
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.store",
	"bootstrap_v4",
	Array(
		"CACHE_NOTES" => "",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"MAP_TYPE" => "0",
		"PHONE" => "N",
		"SCHEDULE" => "N",
		"SEF_FOLDER" => "/store/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array("liststores"=>"index.php","element"=>"#store_id#"),
		"SET_TITLE" => "Y",
		"TITLE" => "Список складов с подробной информацией",
		"VARIABLE_ALIASES" => Array("liststores"=>Array(),"element"=>Array(),)
	)
);?>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>