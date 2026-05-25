<?php
namespace Logika\Api\Controllers;

use Logika\Api\Auth\UserAuth;
use Logika\Api\Response;

class AuthController
{
    /**
     * POST auth/login
     * Body: { email, password }
     */
    public function login(array $params, array $body): void
    {
        global $USER;

        $email    = trim($body['email'] ?? $body['login'] ?? '');
        $password = trim($body['password'] ?? '');

        if (!$email || !$password) {
            Response::error('Email и пароль обязательны', 422);
        }

        $login = $email;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $rsUser = \CUser::GetList(
                ($by = 'id'),
                ($order = 'asc'),
                ['=EMAIL' => $email]
            );
            if ($userData = $rsUser->Fetch()) {
                $login = $userData['LOGIN'];
            }
        }

        $result = $USER->Login($login, $password, 'N');

        if ($result !== true) {
            Response::error('Неверный email или пароль', 401);
        }

        // Bitrix устанавливает PHPSESSID (httpOnly cookie) автоматически
        Response::success(UserAuth::current());
    }

    /**
     * POST auth/logout
     */
    public function logout(array $params, array $body): void
    {
        global $USER;
        $USER->Logout();
        Response::success(['ok' => true]);
    }

    /**
     * GET auth/me  — требует авторизации (роутер проверяет 'user')
     */
    public function me(array $params, array $body): void
    {
        Response::success(UserAuth::current());
    }

    /**
     * POST auth/register
     * Body: { name, email, password, phone? }
     */
    public function register(array $params, array $body): void
    {
        global $USER;

        $name     = trim($body['name']     ?? '');
        $email    = trim($body['email']    ?? '');
        $password = trim($body['password'] ?? '');
        $phone    = trim($body['phone']    ?? '');

        if (!$name || !$email || !$password) {
            Response::error('name, email и password обязательны', 422);
        }

        $result = $USER->Register(
            $email,          // login = email
            $name,           // имя
            '',              // фамилия
            $password,
            $password,       // подтверждение
            $email,
            '',
            '',
            SITE_ID,
            false,
            ['PERSONAL_PHONE' => $phone]
        );

        if ($result['TYPE'] === 'ERROR') {
            Response::error($result['MESSAGE'], 422);
        }

        // Сразу логиним после регистрации
        $USER->Login($email, $password, 'N');
        Response::success(UserAuth::current(), 201);
    }

    /**
     * POST auth/password/reset
     * Body: { email }
     */
    public function resetPassword(array $params, array $body): void
    {
        $email = trim($body['email'] ?? '');
        if (!$email) {
            Response::error('Email обязателен', 422);
        }

        $result = \CUser::SendUserInfo($email, SITE_ID, 'forgot_password', true);

        // Не раскрываем существование email — всегда возвращаем успех
        Response::success(['ok' => true]);
    }
}
