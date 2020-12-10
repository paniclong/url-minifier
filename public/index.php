<?php

declare(strict_types=1);

use League\Route\Strategy\ApplicationStrategy;
use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Router;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Log\LoggerInterface;


require_once __DIR__ . '/../vendor/autoload.php';

$configDir = __DIR__ . '/../config/';

/** @var LoggerInterface $logger */
$logger = (require $configDir . 'monolog.php')();

try {
    // Initialize container
    $builder = new DI\ContainerBuilder();

    $builder->useAutowiring(true);

    $container = $builder->build();

    // Add logger to container
    $container->set(LoggerInterface::class, $logger);

    // Initialize eloquent orm
    $capsule = new Capsule;

    $config = require $configDir . 'db.php';
    $capsule->addConnection($config);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    // Initialize routing
    $router = new Router;

    $strategy = (new ApplicationStrategy)->setContainer($container);
    $router->setStrategy($strategy);

    (require $configDir . 'routes.php')($router);

    $response = $router->dispatch(ServerRequestFactory::fromGlobals());

    // Send response
    (new SapiEmitter)->emit($response);
} catch (Throwable $ex) {
    $logger->error($ex->getMessage(), ['trace' => $ex->getTraceAsString()]);
}
