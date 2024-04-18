<?php

declare(strict_types=1);

if (getenv('ENVIRONMENT', local_only: true) !== 'production') {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env');
    $dotenv->load();
}
