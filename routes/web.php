<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\ArticleController;
use App\Controllers\HomeController;
use App\Controllers\CategoryController;
use App\Controllers\SearchController;
use App\Controllers\ContentController;

return function (App $app) {
    // Language switch route
    $app->any('/switch-lang[/{code}]', function ($request, $response, $args) {
        $code = $args['code'] ?? $request->getQueryParams()['code'] ?? $request->getParsedBody()['code'] ?? 'sk';
        $available = explode(',', $_ENV['AVAILABLE_LANGUAGES'] ?? 'sk,en,cs');
        $default = $_ENV['DEFAULT_LANGUAGE'] ?? 'sk';

        if (in_array($code, $available)) {
            $_SESSION['language'] = $code;
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        $parsed = parse_url($referer);
        $currentPath = $parsed['path'] ?? '/';

        // Remove existing language prefix
        if (preg_match('/^\/(' . implode('|', $available) . ')/', $currentPath, $matches)) {
            $currentPath = substr($currentPath, strlen($matches[0]));
        }

        // Remove trailing slash
        $currentPath = rtrim($currentPath, '/');

        if ($code === $default) {
            $redirect = $currentPath ?: '/';
        } else {
            $redirect = '/' . $code . $currentPath;
        }

        return $response->withHeader('Location', $redirect)->withStatus(302);
    })->add(\App\Middleware\SkipCsrfMiddleware::class);
    // Root route - použije default language (sk)
    $app->get('/', [HomeController::class, 'index'])
        ->setName('home');

    // Routes for default language (without language prefix) - PRIDAJTE SETNAME!
    $app->get('/categories', [CategoryController::class, 'list'])
        ->setName('categories')
        ->add(\App\Middleware\LanguageMiddleware::class);
        
    $app->get('/categories/{slug}', [CategoryController::class, 'detail'])
        ->setName('category.detail.default')
        ->add(\App\Middleware\LanguageMiddleware::class);
        
    $app->get('/article/{slug}', [ArticleController::class, 'detail'])
        ->setName('article.detail.default')
        ->add(\App\Middleware\LanguageMiddleware::class);
        
    $app->get('/articles', [ArticleController::class, 'index'])
        ->setName('articles')
        ->add(\App\Middleware\LanguageMiddleware::class);
        
    $app->get('/search', [SearchController::class, 'index'])
        ->setName('search')
        ->add(\App\Middleware\LanguageMiddleware::class);
        
    $app->get('/content', [ContentController::class, 'index'])
        ->setName('content.index.default')
        ->add(\App\Middleware\LanguageMiddleware::class);
        
    $app->get('/content/{slug}', [ContentController::class, 'show'])
        ->setName('content.show.default')
        ->add(\App\Middleware\LanguageMiddleware::class);

    // Language group
    $app->group('/{lang:[a-z]{2}}', function (RouteCollectorProxy $group) {
        // Homepage with language
        $group->get('', [HomeController::class, 'index'])
              ->setName('home.lang');
        $group->get('/', [HomeController::class, 'index'])
              ->setName('home.lang');

        // Categories
        $group->get('/categories', [CategoryController::class, 'list'])
              ->setName('category.list');

        $group->get('/categories/{slug}', [CategoryController::class, 'detail'])
              ->setName('category.detail');

        // Articles
        $group->get('/article/{slug}', [ArticleController::class, 'detail'])
              ->setName('article.detail');

        $group->get('/articles', [ArticleController::class, 'index'])
              ->setName('article.index');

        // Search
        $group->get('/search', [SearchController::class, 'index'])
              ->setName('search.index');

        // Content (Markdown articles)
        $group->get('/content', [ContentController::class, 'index'])
              ->setName('content.index');

        $group->get('/content/{slug}', [ContentController::class, 'show'])
              ->setName('content.show');

    })->add(\App\Middleware\LanguageMiddleware::class);


};