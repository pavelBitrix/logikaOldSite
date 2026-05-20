<?php
/**
 * GET /local/api/v1/auth/me.php
 * Возвращает данные авторизованного пользователя.
 */

require_once __DIR__ . '/../_bootstrap.php';

$user = api_require_auth();
api_response($user);
