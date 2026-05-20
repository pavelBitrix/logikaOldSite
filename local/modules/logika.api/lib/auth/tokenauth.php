<?php
namespace Logika\Api\Auth;

use Bitrix\Main\Config\Option;

class TokenAuth
{
    private const MODULE = 'logika.api';

    public static function check(): bool
    {
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (!str_starts_with($header, 'Bearer ')) {
            return false;
        }

        $token   = substr($header, 7);
        $stored  = Option::get(self::MODULE, 'api_token', '');

        return $stored !== '' && hash_equals($stored, $token);
    }

    public static function generate(): string
    {
        $token = bin2hex(random_bytes(32));
        Option::set(self::MODULE, 'api_token', $token);
        return $token;
    }
}
