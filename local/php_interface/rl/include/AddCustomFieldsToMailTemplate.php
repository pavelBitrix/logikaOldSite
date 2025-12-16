<?php
AddEventHandler("main", "OnBeforeEventAdd", array("AddCustomFieldsToMailTemplate", "OnBeforeEventAddHandler"));

class AddCustomFieldsToMailTemplate
{
    function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
    {
        $arFields["DEALER_PHONE"] = trim(file_get_contents($_SERVER["DOCUMENT_ROOT"] . SITE_DIR . 'include/header_phone.php'));
        $arFields["DEALER_MAIL"] = trim(file_get_contents($_SERVER["DOCUMENT_ROOT"] . SITE_DIR . 'include/header_mail.php'));
        $arFields["USER_ORDER_MAIL"] = COption::GetOptionString("header_action", "emailOrderList", '');
        $arFields["USER_FEEDBACK_MAIL"] = COption::GetOptionString("header_action", "emailFeedbackList", '');
        $arFields["SERVER_EMAIL"] = 'post@' . $_SERVER['HTTP_HOST'];
    }
}