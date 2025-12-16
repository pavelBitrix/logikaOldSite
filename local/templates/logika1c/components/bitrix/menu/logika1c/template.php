<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="row left-menu d-flex justify-content-center align-items-center">

<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<li class="col-lg-4 row left-menu d-flex justify-content-center align-items-center"><a href="<?=$arItem["LINK"]?>" class="col-9 selected"><?=$arItem["TEXT"]?></a></li>
	<?else:?>
		<li class="col-lg-4 row left-menu d-flex justify-content-center align-items-center"><a href="<?=$arItem["LINK"]?>" class="col-9"><?=$arItem["TEXT"]?></a></li>
	<?endif?>

<?endforeach?>
</ul>
<?endif?>