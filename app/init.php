<?php

use Dotenv\Dotenv;
use Dotenv\Exception\ValidationException;
use Framework\Logger\Logger;

define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
define('APPLICATION_LOGS', __DIR__ . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR);
define('APPLICATION_PATH', __DIR__ . DIRECTORY_SEPARATOR);

// COMPOSER AUTOLOAD
include_once APPLICATION_PATH . '/../vendor/autoload.php';

// LOAD ENVIRONMENT VARIABLES
$dotEnv = Dotenv::createImmutable(APPLICATION_PATH);
$dotEnv->load();

if (!file_exists(APPLICATION_LOGS)) {
    mkdir(APPLICATION_LOGS, 655);
}

try {
    $dotEnv->required([
        'DB_HOST',
        'DB_USER',
        'DB_PASS',
        'DB_PORT',
        'SITE_URL'
    ]);
} catch (ValidationException $e) {
    (new Logger('Database', APPLICATION_LOGS . 'alerts.log'))->get()->alert($e->getMessage(), $e->getTrace());
    http_response_code(500);
    exit;
}

// ENABLE DEBUG
if (getenv('DEBUG') === true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
