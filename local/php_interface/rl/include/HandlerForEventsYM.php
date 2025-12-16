<?php

//RegisterModuleDependences("main", "OnAfterUserRegister", "main", "MyYMEvents", "OnAfterUserRegisterHandler");
AddEventHandler("main", "OnAfterUserRegister", Array("MyYMEvents", "OnAfterUserRegisterHandler"));

class MyYMEvents
{
    function OnAfterUserRegisterHandler($arFields)
    {
        // если регистрация успешна то
        if ($arFields["USER_ID"] > 0) {
            $_SESSION['ADD_NEW_USER'] = $arFields["USER_ID"];
        }
    }
}
