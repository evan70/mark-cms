<?php

use App\Services\BladeService;
use DI\Container;
use Psr\Container\ContainerInterface;

return [
    'settings' => function() {
        return require __DIR__ . '/settings.php';
    },

    BladeService::class => function (ContainerInterface $container) {
        $settings = $container->get('settings');

        $viewPath = $settings['view']['template_path'] ?? __DIR__ . '/../resources/views';
        $cachePath = $settings['view']['cache_path'] ?? __DIR__ . '/../storage/cache/views';

        // Ensure cache directory exists
        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        return new BladeService($viewPath, $cachePath);
    },

    'view' => function (ContainerInterface $container) {
        return $container->get(BladeService::class);
    },

    // Content services
    \App\Services\MarkdownParser::class => function (ContainerInterface $container) {
        return new \App\Services\MarkdownParser();
    },

    \App\Services\ContentService::class => function (ContainerInterface $container) {
        $contentConfig = require __DIR__ . '/content.php';
        return new \App\Services\ContentService(
            $contentConfig['content_path'],
            $container->get(\App\Services\MarkdownParser::class)
        );
    },

    \App\Services\FileManager::class => function (ContainerInterface $container) {
        return new \App\Services\FileManager();
    },

    \App\Services\AIContentGenerator::class => function (ContainerInterface $container) {
        return new \App\Services\AIContentGenerator();
    },

    \App\Controllers\Mark\ContentMarkController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Mark\ContentMarkController(
            $container,
            $container->get(\App\Services\ContentService::class),
            $container->get(\App\Services\FileManager::class)
        );
    },

    \App\Controllers\Mark\AIContentController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Mark\AIContentController($container);
    },

    \App\Services\ArticleLinkService::class => function (ContainerInterface $container) {
        return new \App\Services\ArticleLinkService();
    },

    \App\Services\SearchIndexService::class => function (ContainerInterface $container) {
        return new \App\Services\SearchIndexService();
    },

    \App\Services\SearchService::class => function (ContainerInterface $container) {
        return new \App\Services\SearchService(
            $container->get(\App\Services\SearchIndexService::class)
        );
    },

    \App\Services\DatabaseInitializerService::class => function (ContainerInterface $container) {
        return new \App\Services\DatabaseInitializerService($container->get('logger'));
    },

    \App\Console\Commands\DatabaseInitCommand::class => function (ContainerInterface $container) {
        return new \App\Console\Commands\DatabaseInitCommand(
            $container->get(\App\Services\DatabaseInitializerService::class)
        );
    },

    // Auth Services
    \App\Services\Auth\AuthService::class => function (ContainerInterface $container) {
        return new \App\Services\Auth\AuthService();
    },

    \App\Services\Auth\MarkAuthService::class => function (ContainerInterface $container) {
        return new \App\Services\Auth\MarkAuthService();
    },

    // Auth Middleware
    \App\Middleware\UserAuthMiddleware::class => function (ContainerInterface $container) {
        return new \App\Middleware\UserAuthMiddleware(
            $container->get(\App\Services\Auth\AuthService::class)
        );
    },

    \App\Middleware\MarkAuthMiddleware::class => function (ContainerInterface $container) {
        return new \App\Middleware\MarkAuthMiddleware(
            $container->get(\App\Services\Auth\MarkAuthService::class)
        );
    },

    // Auth Controllers
    \App\Controllers\Auth\AuthController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Auth\AuthController($container);
    },

    \App\Controllers\Auth\MarkAuthController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Auth\MarkAuthController($container);
    },

    // CSRF Protection
    'csrf' => function (ContainerInterface $container) {
        $responseFactory = $container->get('response_factory');

        // Make sure session is started
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Create guard with minimal parameters
        $guard = new \Slim\Csrf\Guard($responseFactory);

        // Configure guard
        // Only use methods that are available in the current version
        if (method_exists($guard, 'setPersistentTokenMode')) {
            $guard->setPersistentTokenMode(false);
        }

        return $guard;
    },

    // Response Factory
    'response_factory' => function (ContainerInterface $container) {
        return new \Slim\Psr7\Factory\ResponseFactory();
    },

    // Session
    'session' => function (ContainerInterface $container) {
        return new \SlimSession\Helper();
    },

    // Logger
    'logger' => function (ContainerInterface $container) {
        $logger = new \Monolog\Logger('app');
        $logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../logs/app.log', \Monolog\Logger::DEBUG));
        return $logger;
    },

    // Skip CSRF Middleware
    \App\Middleware\SkipCsrfMiddleware::class => function (ContainerInterface $container) {
        return new \App\Middleware\SkipCsrfMiddleware();
    },

    // Console Commands
    \App\Console\Commands\SeedCommand::class => function (ContainerInterface $container) {
        return new \App\Console\Commands\SeedCommand();
    },

    // Mark Controllers
    \App\Controllers\Mark\UserController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Mark\UserController($container);
    },

    \App\Controllers\Mark\MarkUserController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Mark\MarkUserController($container);
    },

    \App\Controllers\Mark\DashboardController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Mark\DashboardController($container);
    },

    \App\Controllers\Mark\ArticleController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Mark\ArticleController($container);
    },

    \App\Controllers\Mark\CategoryController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Mark\CategoryController($container);
    },

    \App\Controllers\Mark\TagController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Mark\TagController($container);
    },

    \App\Controllers\Mark\SettingsController::class => function (ContainerInterface $container) {
        return new \App\Controllers\Mark\SettingsController($container);
    },

    \App\Controllers\SearchController::class => function (ContainerInterface $container) {
        return new \App\Controllers\SearchController(
            $container,
            $container->get(\App\Services\SearchService::class)
        );
    },
];
