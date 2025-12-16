<?php

function ALResize($bigImg, $w)
{
    $file = CFile::ResizeImageGet($bigImg, array('width' => $w, 'height' => $w), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $src = $file['src'];
    return $src;
}
function ALResizeCut($bigImg, $w, $h)
{
    $file = CFile::ResizeImageGet($bigImg, ['width' => $w, 'height' => $h], BX_RESIZE_IMAGE_EXACT, true);
    $src = $file['src'];
    return $src;
}

function ALResizeWatermark($bigImg, $w)
{
    $arWaterMark = [];
    if ($GLOBALS['USE_WATERMARK']) {
        $arWaterMark = Array(
            ["name" => "watermark",
                "position" => "bottomright",
//                "size" => "real",
//                'fill'=>'repeat',
                'fill'=>'resize',
                "coefficient" => 0.4,
                'alpha_level' => 30,
                "file" => $_SERVER['DOCUMENT_ROOT'] . SITE_DIR."local/images/watermark.png"
            ]
        );
    }
    $file = CFile::ResizeImageGet($bigImg, array('width' => $w, 'height' => $w), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arWaterMark);
    $src = $file['src'];
    return $src;
}

function ALResizeH($bigImg, $w, $h)
{
    $file = CFile::ResizeImageGet($bigImg, array('width' => $w, 'height' => $h), BX_RESIZE_IMAGE_EXACT , true);
    $src = $file['src'];
    echo $src;
}
function ALResizeH_OnReturn($bigImg, $w, $h)
{
    $file = CFile::ResizeImageGet($bigImg, array('width' => $w, 'height' => $h), BX_RESIZE_IMAGE_EXACT , true);
    $src = $file['src'];
    return $src;
}