<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<div class="search-page">
	<form action="/search/index.php" method="get">
		<? if($arParams["USE_SUGGEST"] === "Y"):
			if(mb_strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"]))
			{
				$arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
				$obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
				$obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
			}
			?>
			<?$APPLICATION->IncludeComponent("bitrix:search.suggest.input", "", array(
					"NAME" => "q",
					"VALUE" => $arResult["REQUEST"]["~QUERY"],
					"INPUT_SIZE" => 100,
					"DROPDOWN_SIZE" => 10,
					"FILTER_MD5" => $arResult["FILTER_MD5"],
				),
				$component, array("HIDE_ICONS" => "Y")
			);?>
			<input class="btn btn-primary" type="submit" value="<?=GetMessage("SEARCH_GO")?>" />
		<?else:?>
			<div class="input-group">
				<input type="text" placeholder="Поиск" class="form-control" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="100" />
				<div class="input-group-append">
					<button class="btn search" type="submit"/>
					<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.2121 11.6361C14.3016 10.1495 14.7895 8.30632 14.5784 6.47538C14.3672 4.64443 13.4725 2.96073 12.0732 1.76112C10.674 0.56151 8.87339 -0.065537 7.03168 0.00542765C5.18996 0.0763923 3.44295 0.840135 2.14016 2.14386C0.837367 3.44758 0.0748746 5.19514 0.00522789 7.0369C-0.0644189 8.87867 0.563916 10.6788 1.76453 12.0772C2.96514 13.4756 4.64948 14.3691 6.48058 14.579C8.31167 14.7888 10.1545 14.2995 11.6403 13.209H11.6392C11.673 13.254 11.709 13.2968 11.7495 13.3384L16.0812 17.6701C16.2921 17.8812 16.5783 17.9999 16.8768 18C17.1753 18.0001 17.4615 17.8816 17.6726 17.6707C17.8838 17.4597 18.0024 17.1735 18.0025 16.8751C18.0026 16.5766 17.8842 16.2903 17.6732 16.0792L13.3415 11.7475C13.3013 11.7068 13.258 11.6692 13.2121 11.635V11.6361ZM13.5024 7.31117C13.5024 8.12381 13.3423 8.92849 13.0314 9.67927C12.7204 10.43 12.2646 11.1122 11.6899 11.6868C11.1153 12.2615 10.4331 12.7173 9.68236 13.0283C8.93158 13.3392 8.1269 13.4993 7.31427 13.4993C6.50163 13.4993 5.69695 13.3392 4.94617 13.0283C4.19539 12.7173 3.51321 12.2615 2.93859 11.6868C2.36397 11.1122 1.90815 10.43 1.59717 9.67927C1.28619 8.92849 1.12613 8.12381 1.12613 7.31117C1.12613 5.66997 1.77809 4.096 2.93859 2.9355C4.09909 1.77499 5.67307 1.12303 7.31427 1.12303C8.95546 1.12303 10.5294 1.77499 11.6899 2.9355C12.8504 4.096 13.5024 5.66997 13.5024 7.31117Z" fill="black"/>
</svg></button>

				</div>
			</div>
		<?endif;?>
		<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
		<? if($arParams["SHOW_WHEN"]):?>
	<script>
	var switch_search_params = function()
	{
		var sp = document.getElementById('search_params');
		var flag;

		if(sp.style.display == 'none')
		{
			flag = false;
			sp.style.display = 'block'
		}
		else
		{
			flag = true;
			sp.style.display = 'none';
		}

		var from = document.getElementsByName('from');
		for(var i = 0; i < from.length; i++)
			if(from[i].type.toLowerCase() == 'text')
				from[i].disabled = flag

		var to = document.getElementsByName('to');
		for(var i = 0; i < to.length; i++)
			if(to[i].type.toLowerCase() == 'text')
				to[i].disabled = flag

		return false;
	}
	</script>
	<br /><a class="search-page-params" href="#" onclick="return switch_search_params()"><?echo GetMessage('CT_BSP_ADDITIONAL_PARAMS')?></a>
	<div id="search_params" class="search-page-params" style="display:<?echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"]? 'block': 'none'?>">
		<?$APPLICATION->IncludeComponent(
			'bitrix:main.calendar',
			'',
			array(
				'SHOW_INPUT' => 'Y',
				'INPUT_NAME' => 'from',
				'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
				'INPUT_NAME_FINISH' => 'to',
				'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
				'INPUT_ADDITIONAL_ATTR' => 'size="10"',
			),
			null,
			array('HIDE_ICONS' => 'Y')
		);?>
	</div>
<?endif?>
</form><br />

<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
endif;?>
</div>