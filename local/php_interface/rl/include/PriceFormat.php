<?php

function PriceFormat($price)
{
    $priceAr = explode(".", $price);
    $kopeck = $priceAr[1];
    if (strlen($kopeck) == 1)
        $kopeck = $kopeck . '0';
    if (strlen($kopeck) == 0)
        $kopeck = '00';
    echo number_format($priceAr[0], 0, '', ' ') . '<sup>' . $kopeck . '</sup>';
}

