<?php

use App\Controllers\Api\ArticleController;
use App\Controllers\Api\CategoryController;
use App\Controllers\Api\TagController;
use App\Middleware\AdminAuthMiddleware;
use App\Middleware\CheckPermission;
use App\Middleware\SkipCsrfMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // API routes - skip CSRF
    $app->group('/api', function (RouteCollectorProxy $group) {
        // Admin API routes
        $group->group('/admin', function (RouteCollectorProxy $group) {
            // Articles Management
            $group->group('/articles', function (RouteCollectorProxy $group) {
                $group->get('', [ArticleController::class, 'index']);
                $group->post('', [ArticleController::class, 'store']);
                $group->put('/{id}', [ArticleController::class, 'update']);
                $group->delete('/{id}', [ArticleController::class, 'delete']);
            })->add(new CheckPermission('manage_articles'));

            // Categories Management
            $group->group('/categories', function (RouteCollectorProxy $group) {
                $group->get('', [CategoryController::class, 'index']);
                $group->post('', [CategoryController::class, 'store']);
                $group->put('/{id}', [CategoryController::class, 'update']);
                $group->delete('/{id}', [CategoryController::class, 'delete']);
            })->add(new CheckPermission('manage_categories'));

            // Tags Management
            $group->group('/tags', function (RouteCollectorProxy $group) {
                $group->get('', [TagController::class, 'index']);
                $group->post('', [TagController::class, 'store']);
                $group->put('/{id}', [TagController::class, 'update']);
                $group->delete('/{id}', [TagController::class, 'delete']);
            })->add(new CheckPermission('manage_tags'));

        })->add(new AdminAuthMiddleware());

        // Public API routes
        $group->group('/{lang}', function (RouteCollectorProxy $group) {
            // Articles
            $group->get('/articles', [ArticleController::class, 'index']);
            $group->get('/articles/{slug}', [ArticleController::class, 'show']);
            
            // Categories
            $group->get('/categories', [CategoryController::class, 'index']);
            $group->get('/categories/{slug}', [CategoryController::class, 'show']);
            
            // Tags
            $group->get('/tags', [TagController::class, 'index']);
            $group->get('/tags/{slug}', [TagController::class, 'show']);
        });
    })->add(new SkipCsrfMiddleware());
};
