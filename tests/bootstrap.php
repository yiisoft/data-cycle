<?php

declare(strict_types=1);

if (getenv('ENVIRONMENT', local_only: true) !== 'ci') {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env');
    $dotenv->load();
}
