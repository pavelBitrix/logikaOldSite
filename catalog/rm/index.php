<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Каталог");
?><div style="width: 60%; margin-left: 20%; }">
	<div id="overlay">
		<div class="popup">
			<h2>Сайт в разработке</h2>
			<p>
				 Уважаемые, посетители сайта! Мы рады, что Вы заглянули к нам на сайт! <br>
				 Обращаем Ваше внимание, что сайт находится в разработке! <br>
 <strong>Вы можете продолжать совершать покупки и оставлять ваши заявки. </strong> <br>
				 Приносим свои извинения за временные неудобства. <br>
				 По всем интересующим Вас вопросам, мы готовы проконсультировать по телефонам: <br>
 <a href="tel:+7(4112)722511"> +7(4112)722511 </a> <br>
 <a href="tel:+79142722511"> +79142722511 </a> <br>
				 а также ответить на все ваши письма по электронной почте: <a href="mailto:logika1c@mail.ru">logika1c@mail.ru</a>.
			</p>
 <button class="close" title="Закрыть" onclick="document.getElementById('overlay').style.display='none';"></button>
		</div>
	</div>
	<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.search",
	"bootstrap_v6",
	Array(
		"ACTION_VARIABLE" => "action",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"COMPONENT_TEMPLATE" => "bootstrap_v4",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "53",
		"IBLOCK_TYPE" => "1c_catalog",
		"LINE_ELEMENT_COUNT" => "3",
		"NO_WORD_LOGIC" => "N",
		"OFFERS_LIMIT" => "5",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "30",
		"PRICE_CODE" => "",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => "",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"RESTART" => "N",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SHOW_PRICE_COUNT" => "1",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"USE_SEARCH_RESULT_ORDER" => "N",
		"USE_TITLE_RANK" => "N"
	)
);?>
</div>
<?
		$mobile_sections = CIBlockSection::GetList (
			Array("NAME" => "ASC"),
			Array("IBLOCK_ID" => 53, "ACTIVE" => "Y"),
			false,
			Array('ID', 'NAME', 'CODE', 'SECTION_PAGE_URL', 'PICTURE', ''));
		?>
		<div class="list-group mobile_products_row">
				<?

					while($ar_fields1 = $mobile_sections->GetNext())
					{
						// $i = 0;
						// if($i == 0) 
						//   print_r($ar_fields1);
						// $i++;
						$file = CFile::ResizeImageGet($ar_fields1['PICTURE'], array('width' => 605, 'height' => (605*0.6)), BX_RESIZE_IMAGE_PROPORTIONAL, true);
						$arFile1 = CFile::GetFileArray($ar_fields1['PICTURE']);
						//$arFile1['SRC'] = $file['src'];
						//$arFile1['SRC_WEBP'] = makeWebp($file['src']);
							if($arFile1)
							echo $arFile1["TITLE"];
					?>
					<a href="<? echo 'catalog/', $ar_fields1['ID'],"/"?>" class="list-group-item">
							
								<span 
									class="catalog-section-list-line-item-img" 
									style="background-image:url('<? echo $arFile1['SRC']; ?>');"
									title="<? echo $arFile1['TITLE']; ?>">
					</span>
								<? if ('Y' != $arParams['HIDE_SECTION_NAME'])
								{
								?>
								<div class="catalog-section-list-line-item-inner">
									<span class="catalog-section-list-line-item-title">
									<? echo $ar_fields1['NAME']; ?> </span>
								</div>
								<?
								}
								?> 
							
							</a>
					<?
					}
				?>
		</div>
		<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>