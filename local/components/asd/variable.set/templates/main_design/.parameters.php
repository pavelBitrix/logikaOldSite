<?php

$set = array(
	'header' => GetMessage("ARLIGHT_ARSTORE_ZAGOLOVOK"),
	'text' => GetMessage("ARLIGHT_ARSTORE_TEKST"),
	'link_title' => GetMessage("ARLIGHT_ARSTORE_ZAGOLOVOK_KNOPKI"),
	'link' => GetMessage("ARLIGHT_ARSTORE_SSYLKA"),
);


$arTemplateParameters = array();
foreach ($set as $k => $val) {
	$arTemplateParameters[$k] = array(
		'NAME' => $val,
		'COLS' => 35,
		'ROWS' => 3
	);
}
