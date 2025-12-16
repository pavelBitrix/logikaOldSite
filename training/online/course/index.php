<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обучение и тестирование");
?><?$APPLICATION->IncludeComponent("bitrix:learning.course.tree", ".default", array(
	"COURSE_ID" => $_REQUEST["COURSE_ID"],
	"COURSE_DETAIL_TEMPLATE" => "index.php?COURSE_ID=#COURSE_ID#",
	"CHAPTER_DETAIL_TEMPLATE" => "chapter.php?CHAPTER_ID=#CHAPTER_ID#",
	"LESSON_DETAIL_TEMPLATE" => "lesson.php?LESSON_ID=#LESSON_ID#",
	"SELF_TEST_TEMPLATE" => "self.php?LESSON_ID=#LESSON_ID#",
	"TESTS_LIST_TEMPLATE" => "course/test_list.php?COURSE_ID=#COURSE_ID#",
	"TEST_DETAIL_TEMPLATE" => "course/test.php?COURSE_ID=#COURSE_ID#&TEST_ID=#TEST_ID",
	"CHECK_PERMISSIONS" => "Y",
	"SET_TITLE" => "Y"
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>