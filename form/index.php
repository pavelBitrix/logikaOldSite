<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"); \CUtil::JSPostUnescape();?><?$APPLICATION->IncludeComponent(
    "bitrix:form.result.new",
    "popup",
    array(
        "COMPONENT_TEMPLATE" => "popup",
        "WEB_FORM_ID" => $_REQUEST["WEB_FORM_ID"],
        "IGNORE_CUSTOM_TEMPLATE" => "Y",
        "USE_EXTENDED_ERRORS" => "Y",
        "SEF_MODE" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "LIST_URL" => "",
        "EDIT_URL" => "",
        "SUCCESS_URL" => "",
        "CHAIN_ITEM_TEXT" => "",
        "CHAIN_ITEM_LINK" => "",
        "VACANCY_IBLOCK_ID" => "",
        "SELECTED_ID" => $_REQUEST["SELECTED_ID"],
        "OPTIONS_IBLOCK_ID" => $_REQUEST["OPTIONS_IBLOCK_ID"],
        "ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
        "IBLOCK_ID" => $_REQUEST["IBLOCK_ID"],
        "USER_CONSENT" => $_REQUEST["USER_CONSENT"],
        "USER_CONSENT_ID" => $_REQUEST["USER_CONSENT_ID"],
        "USER_CONSENT_IS_CHECKED" => $_REQUEST["USER_CONSENT_IS_CHECKED"],
        "USER_CONSENT_IS_LOADED" => $_REQUEST["USER_CONSENT_IS_LOADED"],
        "VARIABLE_ALIASES" => array(
            "WEB_FORM_ID" => "WEB_FORM_ID",
            "RESULT_ID" => "RESULT_ID",
        )
    ),
    false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
