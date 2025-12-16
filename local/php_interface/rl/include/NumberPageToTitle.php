<?php

AddEventHandler('main', 'OnEpilog', array('CMainHandlers', 'OnEpilogHandler'));
class CMainHandlers {
    public static function OnEpilogHandler() {
        if (isset($_GET['PAGEN_1']) && intval($_GET['PAGEN_1'])>0 && stristr($GLOBALS['APPLICATION']->GetCurPage(), 'catalog')) {
            $title = $GLOBALS['APPLICATION']->GetTitle();
            if ($GLOBALS['APPLICATION']->GetPageProperty("title"))
                $title = $GLOBALS['APPLICATION']->GetPageProperty("title");
            $GLOBALS['APPLICATION']->SetPageProperty('title', $title.' - страница '.intval($_GET['PAGEN_1']));
        }
    }
}

