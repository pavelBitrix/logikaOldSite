<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обучение и тестирование");
?><?$APPLICATION->IncludeComponent(
	"bitrix:learning.course.list",
	"",
	Array(
		"SORBY" => "SORT",
		"SORORDER" => "ASC",
		"COURSE_DETAIL_TEMPLATE" => "/training/online/course.php?COURSE_ID=#COURSE_ID#&INDEX=Y",
		"CHECK_PERMISSIONS" => "Y",
		"COURSES_PER_PAGE" => "20",
		"SET_TITLE" => "Y"
	),
false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>