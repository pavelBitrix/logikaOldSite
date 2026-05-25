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

        $userId = (int) $USER->GetID();
        $userData = \CUser::GetByID($userId)->Fetch() ?: [];

        $phone = '';
        foreach (['PERSONAL_PHONE', 'PERSONAL_MOBILE', 'WORK_PHONE', 'UF_PHONE', 'PHONE_NUMBER'] as $field) {
            if (!empty($userData[$field])) {
                $phone = (string) $userData[$field];
                break;
            }
        }

        if ($phone === '' && class_exists(\Bitrix\Main\UserPhoneAuthTable::class)) {
            $phoneAuth = \Bitrix\Main\UserPhoneAuthTable::getList([
                'select' => ['PHONE_NUMBER'],
                'filter' => ['=USER_ID' => $userId],
                'limit'  => 1,
            ])->fetch();

            if (!empty($phoneAuth['PHONE_NUMBER'])) {
                $phone = (string) $phoneAuth['PHONE_NUMBER'];
            }
        }

        $name = trim(($userData['NAME'] ?? '') . ' ' . ($userData['LAST_NAME'] ?? ''));

        return [
            'id'    => $userId,
            'email' => $userData['EMAIL'] ?? $USER->GetEmail(),
            'name'  => $name !== '' ? $name : $USER->GetFullName(),
            'phone' => $phone,
        ];
    }
}
