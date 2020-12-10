<?php

declare(strict_types=1);

return [
    'driver' => 'mysql',
    'host' => 'mysql',
    'database' => getenv('MYSQL_DATABASE') ?? 'service',
    'username' => getenv('MYSQL_USER') ?? 'user',
    'password' => getenv('MYSQL_ROOT_PASSWORD') ?? '12345',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
];
