<?php

use Slim\Factory\AppFactory;
use DI\Container;
use App\Middleware\HtmlCompressorMiddleware;
use App\Providers\DatabaseProvider;
use App\Providers\ViewProvider;
use App\Services\BladeService;
use App\Handlers\HttpErrorHandler;

require __DIR__ . '/../vendor/autoload.php';

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
$routes = require __DIR__ . '/../routes/web.php';
$routes($app);

// Run app
$app->run();
