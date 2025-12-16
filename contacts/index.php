<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
$APPLICATION->SetPageProperty("keywords", "1С, бухгалтерия, автоматизация, внедрение, бухгалтерский учет, оперативный учет, курсы 1С, обновление 1С, управленческий учет, Франчайзи, купить 1С, скачать 1С, 1С бухгалтерия, 1С предприятие, 1С зарплата и кадры, 1С кадры, 1С предприятие, 1С расчет, 1С торговля");
$APPLICATION->SetPageProperty("description", "Продажа, установка, настройка программ 1C, обучение пользователей. Разработка и внедрение систем полной автоматизации предприятий.");

$path = '/bitrix/components/bitrix/main.userconsent.request/templates/.default';
\CJSCore::RegisterExt('main_user_consent', Array(
    'js' => $path . '/user_consent.js',
    'css' => $path . '/user_consent.css',
    'lang' => $path . '/user_consent.php',
    'rel' =>   array()
));
CUtil::InitJSCore(array('popup', 'ajax', 'main_user_consent'));
?><section class="about-logika">
<div class="main_title about">
	 Контакты
</div>
<div class="container contacts_">
	<div class="row">
		<div class="col-lg-6">
			<div class="rekv_title">
				 Номер телефона
			</div>
			<div class="rekv_text">
				 +7 (4112) 505-675 (отдел продаж)
			</div>
 <br>
			<div class="rekv_text">
				 +7 (4112) 505-589 (техподдержка)
			</div>
		</div>
		<div class="col-lg-6">
			<div class="rekv_title">
				 Режим работы
			</div>
			<div class="rekv_text">
				 Пн-Пт: 09:00-18:00, <br>
				 <!-- Сб: 10:00 - 13:00, <br> -->
				 Вс - выходной
			</div>
		</div>
		<div class="col-lg-6">
			<div class="rekv_title">
				 Email
			</div>
			<div class="rekv_text">
				 logika1c@mail.ru
			</div>
		</div>
		<div class="col-lg-6">
			<div class="rekv_title">
				 Адрес
			</div>
			<div class="rekv_text">
				 г. Якутск, проспект Ленина д.1, 6 этаж, офис 609
			</div>
		</div>
	</div>
</div>
 </section><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>