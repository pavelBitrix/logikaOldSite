<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обучение и тестирование");
?><?$APPLICATION->IncludeComponent(
	"bitrix:learning.chapter.detail",
	"",
	Array(
		"COURSE_ID" => $_REQUEST["COURSE_ID"],
		"CHAPTER_ID" => $_REQUEST["CHAPTER_ID"],
		"CHAPTER_DETAIL_TEMPLATE" => "chapter.php?CHAPTER_ID=#CHAPTER_ID#",
		"LESSON_DETAIL_TEMPLATE" => "lesson.php?LESSON_ID=#LESSON_ID#",
		"CHECK_PERMISSIONS" => "Y",
		"SET_TITLE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	),
false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>