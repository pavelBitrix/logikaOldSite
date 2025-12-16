<?php
function CountElementInSection($id){
    $rsSection = CIBlockSection::GetList(array(), array('ID' => $id, 'ELEMENT_SUBSECTIONS' => 'Y', 'PROPERTY' => ['!OBSOLETE' => '-1']), true, array());
    if ($arSection = $rsSection->GetNext()) {
        echo $arSection['ELEMENT_CNT'];
    }
}
