<?php
namespace Logika\Api\Controllers;

use Bitrix\Main\Loader;
use Logika\Api\Response;

class LeadController
{
    // Инфоблок для хранения заявок — создать в админке вручную
    private const IBLOCK_CODE = 'LOGIKA_LEADS';

    public function create(array $params, array $body): void
    {
        $name    = trim($body['name']    ?? '');
        $phone   = trim($body['phone']   ?? '');
        $comment = trim($body['comment'] ?? '');
        $source  = trim($body['source']  ?? 'site');

        if ($name === '' || $phone === '') {
            Response::error('Поля name и phone обязательны', 422);
        }

        $id = $this->saveToIblock($name, $phone, $comment, $source);
        $this->sendEmail($name, $phone, $comment, $source);

        Response::success(['lead_id' => $id], 201);
    }

    private function saveToIblock(string $name, string $phone, string $comment, string $source): int
    {
        Loader::includeModule('iblock');

        $iblockId = $this->getIblockId();

        // Если инфоблок не создан — пропускаем сохранение, только email
        if (!$iblockId) {
            return 0;
        }

        $el = new \CIBlockElement();
        $id = $el->Add([
            'IBLOCK_ID'    => $iblockId,
            'NAME'         => "$name / $phone",
            'ACTIVE'       => 'Y',
            'DATE_CREATE'  => new \CDBResult(),
            'PROPERTY_VALUES' => [
                'PHONE'   => $phone,
                'COMMENT' => $comment,
                'SOURCE'  => $source,
            ],
        ]);

        return (int) $id;
    }

    private function sendEmail(string $name, string $phone, string $comment, string $source): void
    {
        Loader::includeModule('main');

        // Тип почтового события — создать в админке: Настройки → Почта → Типы событий
        \CEvent::Send('LOGIKA_NEW_LEAD', SITE_ID, [
            'LEAD_NAME'    => $name,
            'LEAD_PHONE'   => $phone,
            'LEAD_COMMENT' => $comment ?: '—',
            'LEAD_SOURCE'  => $source,
            'LEAD_DATE'    => date('d.m.Y H:i'),
        ]);
    }

    private function getIblockId(): int
    {
        $res = \CIBlock::GetList([], ['CODE' => self::IBLOCK_CODE, 'CHECK_PERMISSIONS' => 'N']);
        $row = $res->Fetch();
        return $row ? (int) $row['ID'] : 0;
    }
}