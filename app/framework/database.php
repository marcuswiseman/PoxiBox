<?php

if (APPLICATION_ENV == "development") {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'poxibox');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_PORT', 3306);
    define('SITE_URL', 'https://php73.playground/');
} else {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'xx');
    define('DB_USER', 'xxx');
    define('DB_PASSWORD', 'xxx');
    define('DB_PORT', 3306);
    define('SITE_URL', 'xxx');
}

$capsule = new Illuminate\Database\Capsule\Manager();
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => DB_HOST,
    'port'      => DB_PORT,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASSWORD,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

var_dump('test');