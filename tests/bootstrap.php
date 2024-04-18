<?php

declare(strict_types=1);

if ($_ENV['ENVIRONMENT'] ?? null !== 'production') {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}
