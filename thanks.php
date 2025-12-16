<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "Разработка сайтов, веб");
$APPLICATION->SetTitle("Разработка сайтов");
?>

<div style="margin-bottom: 5%;">
	<h1 class="site_title" style="margin: 0 auto;">Спасибо, Ваша заявка успешно отправлена! Мы свяжемся с Вами в ближайшее время! <br>
	Через 5 секунд вы вернетесь на страницу </h1>
</div>

<script>
$(function () {  setTimeout(function() {    window.location.replace("/quiz.php");  }, 5000);});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>