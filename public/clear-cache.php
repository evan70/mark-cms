<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use App\Services\BladeService;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Create Container
$container = new Container();

// Set container definitions
$definitions = require __DIR__ . '/../config/container.php';
foreach ($definitions as $key => $definition) {
    $container->set($key, $definition);
}

// Get BladeService
$bladeService = $container->get(BladeService::class);

// Clear cache
$bladeService->clearCache();

echo "View cache cleared successfully!\n";

// Clear opcache if enabled
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache cleared successfully!\n";
}

// Clear APCu cache if enabled
if (function_exists('apcu_clear_cache')) {
    apcu_clear_cache();
    echo "APCu cache cleared successfully!\n";
}

echo "All caches have been cleared.\n";
