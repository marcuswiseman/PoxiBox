<?php

use Framework\Container\Container;
use Framework\Router\GenericRouter;
use Framework\Settings\GenericSettings;

// TODO - implement load types here, default to controller
$app = new Container([
    new GenericRouter('controllers', $_GET['route']),
    new GenericRouter('assets', $_GET['route'], new GenericSettings(['load-type' => 'resources'])),
]);

$loadPage = $app->start();

if (!$loadPage) {
    http_response_code(404);
    exit;
}