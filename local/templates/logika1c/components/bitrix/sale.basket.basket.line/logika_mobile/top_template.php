<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="bx_small_cart">
	<? if ($arParams['SHOW_PERSONAL_LINK'] == 'Y') : ?>
		<a class="col-6 link_profile" href="<?= $arParams['PATH_TO_PERSONAL'] ?>"><?= GetMessage('TSB1_PERSONAL') ?></a>
	<? endif ?>
	<div class="pr-2">
		<? if ($arParams['SHOW_AUTHOR'] == 'Y') : ?>
			<? if ($USER->IsAuthorized()) :
				$name = trim($USER->GetFullName());
				if (!$name)
					$name = trim($USER->GetLogin());
				if (strlen($name) > 15)
					$name = substr($name, 0, 12) . '...';
			?>
				<a class="link_profile" href="<?= $arParams['PATH_TO_PERSONAL'] ?>">
				<img width="20" height="20"  src="<?=SITE_TEMPLATE_PATH?>/components/bitrix/sale.basket.basket.line/logika_mobile/images/profile.svg">
				 </a>
			<? else : ?>
				<a class="link_profile" href="<?= $arParams['PATH_TO_REGISTER'] ?>?login=yes">
				  <img width="20" height="20"  src="<?=SITE_TEMPLATE_PATH?>/components/bitrix/sale.basket.basket.line/logika_mobile/images/profile.svg">
				</a>
			<? endif ?>
		<? endif ?>
	</div>
	<div>
		<a class="cart" href="<?= $arParams['PATH_TO_BASKET'] ?>">
			<img width="20" height="20"  src="<?=SITE_TEMPLATE_PATH?>/components/bitrix/sale.basket.basket.line/logika_mobile/images/cart.svg">
			<? if ($arParams['SHOW_TOTAL_PRICE'] == 'Y') : ?>
				<? if ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y') : ?>
					<strong><?= $arResult['NUM_PRODUCTS'] ?></strong>
				<? endif ?>
			<? endif ?>
		</a>
	</div>

</div>