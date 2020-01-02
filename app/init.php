<?php

use Dotenv\Dotenv;
use Dotenv\Exception\ValidationException;

define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
define('APPLICATION_PATH', __DIR__ . DIRECTORY_SEPARATOR);

// COMPOSER AUTOLOAD
include_once APPLICATION_PATH . '/../vendor/autoload.php';

// LOAD ENVIRONMENT VARIABLES
$dotEnv = Dotenv::createImmutable(APPLICATION_PATH);
$dotEnv->load();

try {
    $dotEnv->required([
        'DB_HOST',
        'DB_USER',
        'DB_PASS',
        'DB_PORT',
        'SITE_URL'
    ]);
} catch (ValidationException $e) {
    // TODO - Log here
    die($e->getMessage());
}

// ENABLE DEBUG
if (getenv('DEBUG') === true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
