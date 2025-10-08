<?php

declare(strict_types=1);

namespace App\Bootstrap;

use App\Handlers\HttpErrorHandler;
use App\Middleware\HtmlCompressorMiddleware;
use App\Providers\DatabaseProvider;
use App\Providers\SessionProvider;
use App\Providers\ViewProvider;
use App\Services\BladeService;
use DI\Container;
use Slim\App;
use Slim\Factory\AppFactory;

class AppBootstrap
{
    public static function createApp(): App
    {
        // Create Container
        $container = new Container();

        // Set container definitions
        $definitions = require __DIR__ . '/../../config/container.php';
        foreach ($definitions as $key => $definition) {
            $container->set($key, $definition);
        }

        // Create App
        $app = AppFactory::createFromContainer($container);

        // Add Base Path if needed
        // $app->setBasePath('/subfolder'); // Uncomment and modify if your app is in a subfolder

        // Initialize session provider early for CSRF compatibility
        SessionProvider::boot();

        // Bootstrap the application
        self::boot($app);

        return $app;
    }

    public static function boot(App $app): void
    {
        $container = $app->getContainer();

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

        // Register middleware
        $middleware = require __DIR__ . '/../../config/middleware.php';
        $middleware($app);

        // Initialize providers
        DatabaseProvider::boot();
        ViewProvider::boot($container);

        // Register routes
        $authRoutes = require __DIR__ . '/../../routes/auth.php';
        $authRoutes($app);

        $markRoutes = require __DIR__ . '/../../routes/mark.php';
        $markRoutes($app);

        $apiRoutes = require __DIR__ . '/../../routes/api.php';
        $apiRoutes($app);

        $webRoutes = require __DIR__ . '/../../routes/web.php';
        $webRoutes($app);

        // Add final middleware
        $app->add(HtmlCompressorMiddleware::class);
    }
}
