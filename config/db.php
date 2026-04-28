<?php
declare(strict_types=1);

$configFile = __DIR__ . '/db_config.php';
if (file_exists($configFile)) {
    require $configFile;
}

define('DB_HOST', defined('DB_HOST') ? DB_HOST : '127.0.0.1');
define('DB_NAME', defined('DB_NAME') ? DB_NAME : 'college_erp');
define('DB_USER', defined('DB_USER') ? DB_USER : 'root');
define('DB_PASS', defined('DB_PASS') ? DB_PASS : '');

function getDbConnection(): ?PDO
{
    static $pdo = false;
    if ($pdo !== false) {
        return $pdo;
    }
    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    } catch (Throwable $e) {
        $pdo = null;
    }
    return $pdo;
}

function isInstalled(): bool
{
    return file_exists(__DIR__ . '/db_config.php') && getDbConnection() !== null;
}
