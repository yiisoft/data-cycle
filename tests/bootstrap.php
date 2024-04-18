<?php

declare(strict_types=1);

var_dump(getenv('COMPOSER_CACHE_DIR', local_only: true));
exit();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env.local');
$dotenv->load();
