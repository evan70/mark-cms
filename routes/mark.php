<?php

use Slim\App;
use App\Controllers\Mark\DashboardController;
use App\Controllers\Mark\ArticleController;
use App\Controllers\Mark\AuthController;
use App\Controllers\Mark\UserController;
use App\Controllers\Mark\MarkUserController;
use App\Controllers\Mark\SettingsController;
use App\Middleware\AdminAuthMiddleware;
use App\Middleware\MarkAuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Auth routes - bez middleware
    // Tieto cesty sú teraz definované v routes/auth.php
    // $app->group('/mark', function (RouteCollectorProxy $group) {
    //     $group->get('/login', [AuthController::class, 'login']);
    //     $group->post('/login', [AuthController::class, 'login']);
    //     $group->post('/logout', [AuthController::class, 'logout']);
    // });

    // Protected mark routes
    $app->group('/mark', function (RouteCollectorProxy $group) {
        // Dashboard - opravené routes
        $group->get('', [DashboardController::class, 'index'])->setName('mark.dashboard');
        $group->get('/', [DashboardController::class, 'index'])->setName('mark.dashboard.slash');

        // Logout route is defined outside of the protected group

        // Articles management
        $group->group('/articles', function (RouteCollectorProxy $group) {
            $group->get('', [ArticleController::class, 'index'])->setName('mark.articles.index');
            $group->get('/create', [ArticleController::class, 'create'])->setName('mark.articles.create');
            $group->post('', [ArticleController::class, 'store'])->setName('mark.articles.store');
            $group->get('/{id}/edit', [ArticleController::class, 'edit'])->setName('mark.articles.edit');
            $group->put('/{id}', [ArticleController::class, 'update'])->setName('mark.articles.update');
            $group->delete('/{id}', [ArticleController::class, 'delete'])->setName('mark.articles.delete');
        });

        // Regular users management
        $group->group('/users', function (RouteCollectorProxy $group) {
            $group->get('', [UserController::class, 'index'])->setName('mark.users.index');
            $group->get('/create', [UserController::class, 'create'])->setName('mark.users.create');
            $group->post('/create', [UserController::class, 'store']);
            $group->get('/{id}/edit', [UserController::class, 'edit'])->setName('mark.users.edit');
            $group->post('/{id}/edit', [UserController::class, 'update']);
            $group->get('/{id}/delete', [UserController::class, 'delete'])->setName('mark.users.delete');
        });

        // Mark users management
        $group->group('/mark-users', function (RouteCollectorProxy $group) {
            $group->get('', [MarkUserController::class, 'index'])->setName('mark.mark_users.index');
            $group->get('/create', [MarkUserController::class, 'create'])->setName('mark.mark_users.create');
            $group->post('/create', [MarkUserController::class, 'store']);
            $group->get('/{id}/edit', [MarkUserController::class, 'edit'])->setName('mark.mark_users.edit');
            $group->post('/{id}/edit', [MarkUserController::class, 'update']);
            $group->get('/{id}/delete', [MarkUserController::class, 'delete'])->setName('mark.mark_users.delete');
        });

        // Settings
        $group->get('/settings', [SettingsController::class, 'index'])->setName('mark.settings');
        $group->post('/settings/layout', [SettingsController::class, 'updateLayout'])->setName('mark.settings.layout');
    })->add($app->getContainer()->get(MarkAuthMiddleware::class));

    // Logout route - outside of the protected group
    $app->get('/mark/logout', [\App\Controllers\Auth\AuthController::class, 'logout'])->setName('mark.logout');
};
