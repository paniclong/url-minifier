<?php

declare(strict_types=1);

use UrlMinifier\Handler\CreateUrlHandler;
use UrlMinifier\Handler\ReceiveUrlHandler;
use UrlMinifier\Handler\StatusHandler;
use League\Route\Router;

return static function (Router $router) {
    $router->get('/', StatusHandler::class);
    $router->get('/urls', CreateUrlHandler::class);
    $router->get('/{uuid}', ReceiveUrlHandler::class);
};
