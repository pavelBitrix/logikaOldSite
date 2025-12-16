<?php

function GetIBlockSectionId($IBLOCK_ID, $SECTION_ID)
{
    if (intval($SECTION_ID)) {
        $nav = CIBlockSection::GetNavChain($IBLOCK_ID, $SECTION_ID);
        while ($arSectionPath = $nav->GetNext()) {
            $res[] = $arSectionPath;
        }
    }
    return $res[0]['ID'];
}

function GetIBlockSectionAllPath($IBLOCK_ID, $SECTION_ID)
{
    $res = [];
    if (intval($SECTION_ID)) {
        $nav = CIBlockSection::GetNavChain($IBLOCK_ID, $SECTION_ID);
        while ($arSectionPath = $nav->GetNext()) {
            $res[] = $arSectionPath;
        }
    }
    return $res;
}

function getContentFromFilterFile($externalID, $sectionsPathInfo, $onlyTopLevel = false)
{
    $filePath = '';
    global $USER;
    $level = count($sectionsPathInfo);
    $currentExternalID = $sectionsPathInfo[$level - 1]['XML_ID'];
    $resultPath = '';
//    if (&& isset($currentExternalID) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/assets/json/filters/') && ($USER->IsAdmin() || $USER->GetLogin() == 'v.zhabin@arlight.ru')) {
    if (isset($currentExternalID) && file_exists($_SERVER['DOCUMENT_ROOT']. SITE_DIR . 'assets/json/filters/')) {
        if ($onlyTopLevel) {
            $level = 1;
            $currentExternalID = $sectionsPathInfo[0]['XML_ID'];
        }
        getFilterFile($sectionsPathInfo, $level, $currentExternalID, $resultPath);
        if ($resultPath)
            $filePath = $resultPath;
    } else
        if (file_exists($_SERVER['DOCUMENT_ROOT']. SITE_DIR . 'assets/json/filterSettings_' . $externalID . ".json"))
            $filePath = $_SERVER['DOCUMENT_ROOT']. SITE_DIR . 'assets/json/filterSettings_' . $externalID . ".json";

    return $filePath;
}

function getFilterFile($sectionsPathInfo, $level, $id, &$resultPath)
{
    if ($level > 0) {
        $filePath = $_SERVER['DOCUMENT_ROOT']. SITE_DIR . 'assets/json/filters/filterSettings_' . $id . ".json";
        if (file_exists($filePath)) {
            $resultPath = $filePath;
        } else {
            $level--;
            getFilterFile($sectionsPathInfo, $level, $sectionsPathInfo[$level - 1]['XML_ID'], $resultPath);
        }
    }
}