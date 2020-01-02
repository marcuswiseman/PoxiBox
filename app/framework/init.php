<?php

define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
define('APPLICATION_PATH', __DIR__ . DIRECTORY_SEPARATOR);

include_once APPLICATION_PATH . '/../../vendor/autoload.php';
include_once APPLICATION_PATH . '/database.php';

if (APPLICATION_ENV != 'production') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}