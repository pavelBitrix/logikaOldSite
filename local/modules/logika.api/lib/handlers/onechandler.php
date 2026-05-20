<?php
namespace Logika\Api\Handlers;

use Bitrix\Main\Loader;

/**
 * Handles CommerceML 2.x protocol used by 1C for catalog/order sync.
 *
 * 1C calls this handler in sequence:
 *   1. checkauth  — validate credentials, return session cookie
 *   2. init       — declare upload directory and file size limit
 *   3. file       — upload XML/ZIP chunks
 *   4. import     — parse uploaded XML and sync data
 *   5. deactivate — deactivate items absent in the last import
 */
class OneCHandler
{
    private string $type;
    private string $mode;
    private string $uploadDir;

    public function __construct(string $type, string $mode)
    {
        $this->type      = $type;
        $this->mode      = $mode;
        $this->uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload/1c_exchange/';
    }

    public function handle(): void
    {
        match ($this->mode) {
            'checkauth'  => $this->checkAuth(),
            'init'       => $this->init(),
            'file'       => $this->receiveFile(),
            'import'     => $this->import(),
            'deactivate' => $this->deactivate(),
            default      => $this->fail('Unknown mode'),
        };
    }

    private function checkAuth(): void
    {
        $login    = $_SERVER['PHP_AUTH_USER'] ?? '';
        $password = $_SERVER['PHP_AUTH_PW']   ?? '';

        // Validate against Bitrix admin user
        $user = new \CUser();
        if (!$user->Login($login, $password)) {
            $this->fail('Unauthorized');
        }

        $phpSessionId = session_id();
        echo "success\n";
        echo "PHPSESSID\n";
        echo "$phpSessionId\n";
    }

    private function init(): void
    {
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0775, true);
        }

        $limit = min((int) ini_get('post_max_size'), (int) ini_get('upload_max_filesize'));

        echo "zip=yes\n";
        echo "file_limit=$limit\n";
    }

    private function receiveFile(): void
    {
        $filename = basename($_GET['filename'] ?? 'import.xml');
        $filepath = $this->uploadDir . $filename;

        $data = file_get_contents('php://input');
        if ($data === false) {
            $this->fail('Cannot read file data');
        }

        file_put_contents($filepath, $data, FILE_APPEND);

        // Unzip if needed
        if (str_ends_with($filename, '.zip')) {
            $zip = new \ZipArchive();
            if ($zip->open($filepath) === true) {
                $zip->extractTo($this->uploadDir);
                $zip->close();
                unlink($filepath);
            }
        }

        echo "success\n";
    }

    private function import(): void
    {
        Loader::includeModule('iblock');
        Loader::includeModule('catalog');

        $filename = basename($_GET['filename'] ?? 'import.xml');
        $filepath = $this->uploadDir . $filename;

        if (!file_exists($filepath)) {
            $this->fail("File not found: $filename");
        }

        // Delegate to Bitrix built-in 1C importer
        $import = new \CIBlockCMLImport();
        $import->Init('LOGIKA_CATALOG', $filepath);

        while (!$import->IsAllDone()) {
            $import->ImportNextStep();
        }

        echo "success\n";
    }

    private function deactivate(): void
    {
        // Built-in Bitrix deactivation is handled by CIBlockCMLImport
        echo "success\n";
    }

    private function fail(string $message): void
    {
        echo "failure\n";
        echo "$message\n";
        exit;
    }

    // Event handler: called after CRM lead is created
    public static function onLeadCreated(array &$fields): void
    {
        // Hook point — send notification to 1C or Telegram bot
    }
}
