<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обучение и тестирование");
?><?$APPLICATION->IncludeComponent("bitrix:learning.course", "courses", array(
	"COURSE_ID" => "\$_REQUEST['COURSE_ID']",
	"SEF_MODE" => "N",
	"SEF_FOLDER" => "/learning/",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"CHECK_PERMISSIONS" => "Y",
	"PATH_TO_USER_PROFILE" => "/company/personal/user/#USER_ID#/",
	"SET_TITLE" => "Y",
	"PAGE_WINDOW" => "10",
	"SHOW_TIME_LIMIT" => "Y",
	"PAGE_NUMBER_VARIABLE" => "PAGE",
	"TESTS_PER_PAGE" => "20",
	"VARIABLE_ALIASES" => array(
		"COURSE_ID" => "COURSE_ID",
		"INDEX" => "INDEX",
		"LESSON_ID" => "LESSON_ID",
		"CHAPTER_ID" => "CHAPTER_ID",
		"SELF_TEST_ID" => "SELF_TEST_ID",
		"TEST_ID" => "TEST_ID",
		"TYPE" => "TYPE",
		"TEST_LIST" => "TEST_LIST",
		"GRADEBOOK" => "GRADEBOOK",
		"FOR_TEST_ID" => "FOR_TEST_ID",
	)
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>