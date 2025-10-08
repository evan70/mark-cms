<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Create and bootstrap the application
$app = \App\Bootstrap\AppBootstrap::createApp();

// Run app
$app->run();
