<?php

declare(strict_types=1);

if ($_ENV['environment'] ?? null !== 'production') {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}
