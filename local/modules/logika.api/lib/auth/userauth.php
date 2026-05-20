<?php
namespace Logika\Api\Auth;

class UserAuth
{
    public static function check(): bool
    {
        global $USER;
        return $USER instanceof \CUser && $USER->IsAuthorized();
    }

    public static function id(): int
    {
        global $USER;
        return self::check() ? (int) $USER->GetID() : 0;
    }

    public static function current(): ?array
    {
        global $USER;
        if (!self::check()) {
            return null;
        }
        return [
            'id'    => (int) $USER->GetID(),
            'email' => $USER->GetEmail(),
            'name'  => $USER->GetFullName(),
            'phone' => $USER->GetParam('PERSONAL_PHONE') ?? '',
        ];
    }
}
