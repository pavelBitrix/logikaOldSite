<?php

class Helpers
{
    // Заменить  текст статуса наличия товара  в карточке
    public static function changeTextAvailableStatus($statusCode)
    {
        $newStatus = '';
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . SITE_DIR."assets/json/availableStatus.json")) {
            $availableAr = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . SITE_DIR."assets/json/availableStatus.json"), true);
            if (isset($availableAr[$statusCode]))
                $newStatus = trim($availableAr[$statusCode]);
        }
        return $newStatus;
    }
}
