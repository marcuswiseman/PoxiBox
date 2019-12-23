<?php

use Framework\Container\Container;
use Framework\Router\GenericRouter;
use Framework\Settings\GenericSettings;

require_once __DIR__ . '/../app/framework/init.php';


$app = new Container([
    new GenericRouter('pages', $_GET['route'], new GenericSettings()),
]);

$loadPage = $app->up();

if (!$loadPage) {
    http_response_code(404);
    $pageNotFound = realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'app', 'pages', '404.php']));
    if ($pageNotFound) {
        include($pageNotFound);
    }
    exit;
}