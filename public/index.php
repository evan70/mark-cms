<?php

use Slim\Factory\AppFactory;
use DI\Container;
use App\Middleware\HtmlCompressorMiddleware;
use App\Providers\DatabaseProvider;
use App\Providers\ViewProvider;
use App\Services\BladeService;
use App\Handlers\HttpErrorHandler;

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Set session name before any session is started
$sessionName = $_ENV['SESSION_NAME'] ?? 'mark_session';
ini_set('session.name', $sessionName);
session_name($sessionName);

// Create Container
$container = new Container();

// Set container definitions
$definitions = require __DIR__ . '/../config/container.php';
foreach ($definitions as $key => $definition) {
    $container->set($key, $definition);
}

// Create App
$app = AppFactory::createFromContainer($container);

// Add Base Path if needed
// $app->setBasePath('/subfolder'); // Uncomment and modify if your app is in a subfolder

// Add routing middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = new HttpErrorHandler(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    $container->get(BladeService::class)
);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Initialize providers
DatabaseProvider::boot();
ViewProvider::boot($container);

// Register middleware
$middleware = require __DIR__ . '/../config/middleware.php';
$middleware($app);

// Register routes
// Auth routes must be registered before web routes because web routes have a wildcard route
$authRoutes = require __DIR__ . '/../routes/auth.php';
$authRoutes($app);

$markRoutes = require __DIR__ . '/../routes/mark.php';
$markRoutes($app);

$apiRoutes = require __DIR__ . '/../routes/api.php';
$apiRoutes($app);

// Web routes must be registered last because they have a wildcard route
$webRoutes = require __DIR__ . '/../routes/web.php';
$webRoutes($app);

// Run app
$app->run();
