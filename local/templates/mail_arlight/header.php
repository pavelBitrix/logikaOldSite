<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();
if (!defined("SITE_DIR"))
    define("SITE_DIR", '/');
if (!defined("SITE_SERVER_NAME"))
    define("SITE_SERVER_NAME", $_SERVER["HTTP_HOST"]);
global $SITE_SERVER_NAME;
$SITE_SERVER_NAME = SITE_SERVER_NAME;
if ($SITE_SERVER_NAME == '') $SITE_SERVER_NAME = $_SERVER["HTTP_HOST"];
global $SITE_DIR;
$SITE_DIR = SITE_DIR;
if ($SITE_DIR == '') $SITE_DIR = '/';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <style>
        body {
            font-family: 'Arial', 'Tahoma', 'Helvetica', sans-serif;
            font-size: 12px;
            color: #435363;
        }
    </style>
</head>
<body>

<table style="font-family: Arial, sans-serif;" align="center" width="700" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td>
            <table width="700" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td align="center" bgcolor="#eee" valign="middle" style="padding: 10px;">
                        <a href="http://<?= $SITE_SERVER_NAME ?>" target="_blank">
                            <img src="http://<?= $SITE_SERVER_NAME ?><?= $SITE_DIR ?>images/header_logo.png" alt=""
                                 style="height: 40px;"></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top">
            <table width="700" cellpadding="20" cellspacing="0" style="background-color:#fafafa;">
                <tbody>
                <tr>
                    <td>
