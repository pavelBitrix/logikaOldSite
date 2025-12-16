<?php

$set = array(
	'var1' => GetMessage("ARLIGHT_ARSTORE_RAZ_PEREMENNAA"),
	'var2' => GetMessage("ARLIGHT_ARSTORE_DVA_PEREMENNAA"),
	'var3' => GetMessage("ARLIGHT_ARSTORE_I_ESE_PEREMENNAA"),
);


$arTemplateParameters = array();
foreach ($set as $k => $val) {
	$arTemplateParameters[$k] = array(
		'NAME' => $val,
		'COLS' => 35,
		'ROWS' => 3
	);
}
