<?php

use Framework\Container\Container;
use Framework\Router\GenericRouter;

require_once __DIR__ . '/../app/framework/init.php';

$app = new Container([
    new GenericRouter('controllers', $_GET['route']),
]);

$loadPage = $app->start();

if (!$loadPage) {
    http_response_code(404);
    exit;
}