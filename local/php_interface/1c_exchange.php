<?php
/**
 * 1C ↔ Bitrix exchange endpoint (CommerceML protocol).
 * 1C calls this URL to sync catalog, orders, prices.
 *
 * URL: /1c-exchange/?type=catalog&mode=init|checkauth|file|import
 */

define('NO_KEEP_STATISTIC', true);
define('NO_AGENT_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('STOP_STATISTICS', true);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Loader;
use Logika\Api\Handlers\OneCHandler;

Loader::includeModule('logika.api');
Loader::includeModule('catalog');

$type = $_GET['type'] ?? 'catalog';   // catalog | sale
$mode = $_GET['mode'] ?? 'checkauth'; // checkauth | init | file | import | deactivate

$handler = new OneCHandler($type, $mode);
$handler->handle();
