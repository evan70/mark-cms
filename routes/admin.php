<?php

use Slim\App;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ArticleController;
use App\Controllers\Admin\AuthController;
use App\Middleware\AdminAuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Auth routes - bez middleware
    $app->group('/admin', function (RouteCollectorProxy $group) {
        $group->get('/login', [AuthController::class, 'login']);
        $group->post('/login', [AuthController::class, 'login']);
        $group->post('/logout', [AuthController::class, 'logout']);
    });

    // Protected admin routes
    $app->group('/admin', function (RouteCollectorProxy $group) {
        // Dashboard - opravené routes
        $group->get('', [DashboardController::class, 'index'])->setName('admin.dashboard');
        $group->get('/', [DashboardController::class, 'index'])->setName('admin.dashboard.slash');

        // Articles management
        $group->group('/articles', function (RouteCollectorProxy $group) {
            $group->get('', [ArticleController::class, 'index'])->setName('admin.articles.index');
            $group->get('/create', [ArticleController::class, 'create'])->setName('admin.articles.create');
            $group->post('', [ArticleController::class, 'store'])->setName('admin.articles.store');
            $group->get('/{id}/edit', [ArticleController::class, 'edit'])->setName('admin.articles.edit');
            $group->put('/{id}', [ArticleController::class, 'update'])->setName('admin.articles.update');
            $group->delete('/{id}', [ArticleController::class, 'delete'])->setName('admin.articles.delete');
        });
    })->add(new AdminAuthMiddleware());
};
