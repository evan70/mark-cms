<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\ArticleController;
use App\Controllers\HomeController;
use App\Controllers\CategoryController;
use App\Controllers\SearchController;
use App\Controllers\ContentController;

return function (App $app) {
    // Root route - použije default language (sk)
    $app->get('/', [HomeController::class, 'index'])
        ->setName('home');

    // Routes for default language (without language prefix) - PŘIDAJTE SETNAME!
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

    // Wildcard route pre handling 404
    $app->any('{route:.*}', function ($request, $response) {
        throw new \Slim\Exception\HttpNotFoundException($request);
    });
};