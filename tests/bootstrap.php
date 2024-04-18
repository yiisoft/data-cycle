<?php

declare(strict_types=1);

var_dump(getenv('ENVIRONMENT', local_only: true));
var_dump(getenv('CYCLE_MYSQL_DATABASE', local_only: true));
exit;

if (getenv('ENVIRONMENT', local_only: true) !== 'production') {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env');
    $dotenv->load();
}
