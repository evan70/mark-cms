
<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\ArticleController;
use App\Controllers\HomeController;
use App\Controllers\CategoryController;

return function (App $app) {
    // Root route - použije default language (sk)
    $app->get('/', [HomeController::class, 'index'])
        ->setName('home');

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

    })->add(\App\Middleware\LanguageMiddleware::class);

    // Wildcard route pre handling 404
    $app->any('{route:.*}', function ($request, $response) {
        throw new \Slim\Exception\HttpNotFoundException($request);
    });
};
