<?php
/**
 * POST /local/api/v1/auth/logout.php
 * Завершает сессию пользователя.
 */

require_once __DIR__ . '/../_bootstrap.php';

global $USER;
$USER->Logout();

api_response(['ok' => true]);
