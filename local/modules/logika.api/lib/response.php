<?php
namespace Logika\Api;

class Response
{
    public static function success(mixed $data = null, int $code = 200): void
    {
        http_response_code($code);
        echo json_encode(['success' => true, 'data' => $data], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function error(string $message, int $code = 400, array $details = []): void
    {
        http_response_code($code);
        echo json_encode([
            'success' => false,
            'error'   => $message,
            'details' => $details,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
