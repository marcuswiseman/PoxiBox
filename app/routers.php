<?php

use Framework\Container\Container;
use Framework\Router\GenericRouter;
use Framework\Settings\GenericSettings;

$app = new Container([
    new GenericRouter('assets', $_GET['route'], new GenericSettings(['mode' => GenericRouter::MODE_RESOURCE])),
    new GenericRouter('controllers', $_GET['route']),
]);

$loadPage = $app->start();

if (!$loadPage) {
    http_response_code(404);
    exit;
}