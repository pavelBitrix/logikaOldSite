<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$userConsentId = Bitrix\Main\Config\Option::get("bitrix.franchise", "uc_show");
if ($userConsentId > 0) {
    $aMenuLinks = array_merge($aMenuLinks, array(
        array(
            Bitrix\Main\Config\Option::get("bitrix.franchise", "uc_title"),
            Bitrix\Main\UserConsent\AgreementLink::getUri($userConsentId, array(), SITE_DIR.'userconsent/'),
            Array(),
            Array("BOTTOM_ONLY" => "Y"),
            ""
        )
    ));
}
