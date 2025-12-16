<?
function pluralRules($n, $forms) {

if (($n % 10 == 1) && ($n % 100 != 11)) { // n mod 10 is 1 and n mod 100 is not 11;
return $forms[0];
}


if (in_array($n % 10, array(2, 3, 4)) && (!in_array($n % 100, array(12, 13, 14)))) { // n mod 10 in 2..4 and n mod 100 not in 12..14
return $forms[1];
}

if ( ($n % 10 == 0) || (in_array($n % 10, array(5, 6, 7, 8, 9))) || (in_array($n % 100, array(11, 12, 13, 14))) ) { // n mod 10 is 0 or n mod 10 in 5..9 or n mod 100 in 11..14;
return $forms[2];
}
return $forms[3];


}