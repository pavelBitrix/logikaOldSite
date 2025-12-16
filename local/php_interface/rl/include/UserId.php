<?php
function GetUserID()
{
    global $USER;
    if ($USER->IsAuthorized()) {
        $idUser = $USER->GetID();
    } else {
        if(isset($_COOKIE['BX_USER_ID']) && $_COOKIE['BX_USER_ID'] !== '') $idUser = $_COOKIE['BX_USER_ID'];
        elseif(isset($_COOKIE['PHPSESSID']) && $_COOKIE['BX_USER_ID'] !== '') $idUser = $_COOKIE['PHPSESSID'];
        else $idUser = md5(json_encode($_SESSION));
    }
    return $idUser;
}

