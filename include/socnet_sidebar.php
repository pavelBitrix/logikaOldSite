<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$APPLICATION->IncludeComponent("bitrix:eshop.socnet.links", "bootstrap_v5", Array(
	"COMPONENT_TEMPLATE" => "bootstrap_v4",
		"FACEBOOK" => "https://www.facebook.com/1CBitrix",	// Ссылку на страницу в Facebook
		"VKONTAKTE" => "https://vk.com/bitrix_1c",	// Ссылку на страницу в Vkontakte
		"TWITTER" => "https://twitter.com/1c_bitrix",	// Ссылку на страницу в Twitter
		"GOOGLE" => "https://plus.google.com/111119180387208976312/",	// Ссылку на страницу в Google
		"INSTAGRAM" => "https://instagram.com/1CBitrix/",	// Ссылку на страницу в Instagram
	),
	false,
	array(
	"HIDE_ICONS" => "N",
		"ACTIVE_COMPONENT" => "N"
	)
);?>