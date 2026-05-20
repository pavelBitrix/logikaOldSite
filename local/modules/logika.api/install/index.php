<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

class logika_api extends CModule
{
    public $MODULE_ID          = 'logika.api';
    public $MODULE_VERSION     = '1.0.0';
    public $MODULE_VERSION_DATE = '2026-05-20';
    public $MODULE_NAME        = 'Logika — REST API';
    public $MODULE_DESCRIPTION = 'REST API for Nuxt frontend + 1C exchange';
    public $PARTNER_NAME       = 'Logika';

    public function DoInstall(): bool
    {
        ModuleManager::registerModule($this->MODULE_ID);
        return true;
    }

    public function DoUninstall(): bool
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);
        return true;
    }
}
