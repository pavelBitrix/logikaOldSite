<?php
function PrepareLinkSocNetwork()
{
    $file = $_SERVER['DOCUMENT_ROOT'] . SITE_DIR."socialNetwork.json";
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . SITE_DIR."assets/json/socialNetwork.json"))
        $file = $_SERVER['DOCUMENT_ROOT'] . SITE_DIR."assets/json/socialNetwork.json";
    $linksArr = json_decode(json_encode(json_decode(file_get_contents($file))), true);
    if (is_array($linksArr)) {
        return $linksArr;
    }
}


