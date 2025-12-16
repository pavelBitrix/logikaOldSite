<?php

function GetIdSectionFromXmlId($xmlId)
{
    $arFields = [];
    if (intval($xmlId)) {
        $arSelect = ['ID'];
        $arFilter = ["IBLOCK_ID" => CATALOG_ID, "ACTIVE" => "Y", "XML_ID" => $xmlId];

        $arProj = CIBlockSection::GetList(["SORT" => "ASC"], $arFilter, false, $arSelect, false);
        while ($projRes = $arProj->GetNextElement()) {
            $arFields = $projRes->GetFields();
        }
    }
    return $arFields["ID"];
}