<?php

function GetArrayOrString($value)
{
    $val = '';
    $isAr = stripos($value, ';');
    if ($isAr) {
        $val = explode(';', $value);
    } else {
        $val = $value;
    }
    return $val;
}