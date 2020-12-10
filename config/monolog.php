<?php

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

return static function() {
    $logger = new Logger('main');

    $logger->pushHandler(new StreamHandler('/var/log/main.log'));

    return $logger;
};
