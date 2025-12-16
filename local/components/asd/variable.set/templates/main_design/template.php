<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>

<div class="promo-text">
	<div class="promo-text__title">
		<h2><?= $arParams['header']?></h2>
	</div>
	<div class="promo-text__description">
		<p><?= $arParams['text']?></p>
		<a href="<?= $arParams['link']?>" class="promo-text__more link link--main link--present">
			<i class="link__icon icon icon--arrow-right-o icon--24"></i><span><?=GetMessage("ARLIGHT_ARSTORE_UZNATQ_BOLQSE")?></span>
		</a>
	</div>
	<div class="promo-text__ctrl">
		<a href="<?= $arParams['link']?>" class="promo-text__button button  button--second">
			<?= $arParams['link_title']?>
		</a>
	</div>
</div>