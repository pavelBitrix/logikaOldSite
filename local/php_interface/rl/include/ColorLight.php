<?php

function ALColor($COLOR)
{
    $backgr = [];
    $isAr = stripos($COLOR, ';');
    if ($isAr) {
        $colorAr = explode(';', $COLOR);
        $colorArLength = count($colorAr);
        if ($colorArLength == 2) {
            $backgr = 'linear-gradient(135deg,' . $colorAr[0] . ' 0%,' . $colorAr[0] . ' 25%, ' . $colorAr[1] . ' 60%, ' . $colorAr[1] . ' 100%);';
        } elseif ($colorArLength == 3) {
            $backgr = 'linear-gradient(135deg, ' . $colorAr[0] . ' 0%, ' . $colorAr[0] . ' 35%, ' . $colorAr[1] . ' 45%,' . $colorAr[1] . ' 60%,' . $colorAr[2] . ' 65%,' . $colorAr[2] . ' 100%);';
        } elseif ($colorArLength == 4){
            $backgr = 'linear-gradient(135deg, ' . $colorAr[0] . ' 0%, ' . $colorAr[0] . ' 27%, ' . $colorAr[1] . ' 40%,' . $colorAr[1] . ' 50%,' . $colorAr[2] . ' 60%,'  . $colorAr[3] . ' 73%,' . $colorAr[3] . ' 100%);';
        }elseif ($colorArLength == 5){
            $backgr = 'linear-gradient(135deg, ' . $colorAr[0] . ' 0%, ' . $colorAr[0] . ' 25%, ' . $colorAr[1] . ' 35%,' . $colorAr[1] . ' 45%,' . $colorAr[2] . ' 55%,'  . $colorAr[3] . ' 65%,'  . $colorAr[4] . ' 75%,' . $colorAr[4] . ' 100%);';
        }
    } else {
        $backgr = $COLOR;
    }
    echo $backgr;
}

function ALColor2($COLOR)
{
    $backgr = [];
    $isAr = stripos($COLOR, ';');
    if ($isAr) {
        $colorAr = explode(';', $COLOR);
        foreach ($colorAr as $colorItem){
            $backgr[$colorItem]=$colorItem;
        }
    } else {
        $backgr[$COLOR] = $COLOR;
    }
    return $backgr;
}