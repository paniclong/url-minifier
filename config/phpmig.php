<?php

declare(strict_types=1);

use Phpmig\Adapter;
use Illuminate\Database\Capsule\Manager as Capsule;

$container = new ArrayObject();

$config = require __DIR__ . DIRECTORY_SEPARATOR . 'db.php';

$container['config'] = $config;

$container['db'] = static function ($c) {
    $capsule = new Capsule();
    $capsule->addConnection($c['config']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container['schema'] = static function ($c) {
    return $c['db']($c)::schema();
};

$container['phpmig.adapter'] = new Adapter\Illuminate\Database($container['db']($container), 'migrations');
$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . '../migrations';

return $container;
