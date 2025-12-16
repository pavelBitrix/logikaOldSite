<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обучение и тестирование");
?><?$APPLICATION->IncludeComponent(
	"bitrix:learning.lesson.detail",
	"",
	Array(
		"COURSE_ID" => $_REQUEST["COURSE_ID"],
		"LESSON_ID" => $_REQUEST["LESSON_ID"],
		"SELF_TEST_TEMPLATE" => "self.php?COURSE_ID=#COURSE_ID#&LESSON_ID=#LESSON_ID#",
		"CHECK_PERMISSIONS" => "Y",
		"SET_TITLE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	),
false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>