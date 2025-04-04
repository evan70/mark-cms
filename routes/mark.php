<?php

use Slim\App;
use App\Controllers\Mark\DashboardController;
use App\Controllers\Mark\ArticleController;
use App\Controllers\Mark\AuthController;
use App\Controllers\Mark\UserController;
use App\Controllers\Mark\MarkUserController;
use App\Controllers\Mark\SettingsController;
use App\Controllers\Mark\CategoryController;
use App\Controllers\Mark\TagController;
use App\Controllers\Mark\ContentMarkController;
use App\Controllers\Mark\AIContentController;
use App\Controllers\Mark\MediaController;
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

        // Content management (Markdown files)
        $group->group('/content', function (RouteCollectorProxy $group) {
            $group->get('', [ContentMarkController::class, 'index'])->setName('mark.content.index');
            $group->get('/create', [ContentMarkController::class, 'create'])->setName('mark.content.create');
            $group->post('/create', [ContentMarkController::class, 'store'])->setName('mark.content.store');
            $group->get('/{filename}/edit', [ContentMarkController::class, 'edit'])->setName('mark.content.edit');
            $group->post('/{filename}/edit', [ContentMarkController::class, 'update'])->setName('mark.content.update');
            $group->get('/{filename}/delete', [ContentMarkController::class, 'delete'])->setName('mark.content.delete');
        });

        // AI Content Generator
        $group->group('/ai-content', function (RouteCollectorProxy $group) {
            $group->get('', [AIContentController::class, 'index'])->setName('mark.ai-content.index');
            $group->post('/generate', [AIContentController::class, 'generate'])->setName('mark.ai-content.generate');
        });

        // Categories management
        $group->group('/categories', function (RouteCollectorProxy $group) {
            $group->get('', [CategoryController::class, 'index'])->setName('mark.categories.index');
            $group->get('/create', [CategoryController::class, 'create'])->setName('mark.categories.create');
            $group->post('/create', [CategoryController::class, 'store'])->setName('mark.categories.store');
            $group->get('/{id}/edit', [CategoryController::class, 'edit'])->setName('mark.categories.edit');
            $group->post('/{id}/edit', [CategoryController::class, 'update'])->setName('mark.categories.update');
            $group->get('/{id}/delete', [CategoryController::class, 'delete'])->setName('mark.categories.delete');
        });

        // Tags management
        $group->group('/tags', function (RouteCollectorProxy $group) {
            $group->get('', [TagController::class, 'index'])->setName('mark.tags.index');
            $group->get('/create', [TagController::class, 'create'])->setName('mark.tags.create');
            $group->post('/create', [TagController::class, 'store'])->setName('mark.tags.store');
            $group->get('/{id}/edit', [TagController::class, 'edit'])->setName('mark.tags.edit');
            $group->post('/{id}/edit', [TagController::class, 'update'])->setName('mark.tags.update');
            $group->get('/{id}/delete', [TagController::class, 'delete'])->setName('mark.tags.delete');
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

        // Media management
        $group->group('/media', function (RouteCollectorProxy $group) {
            $group->get('', [MediaController::class, 'index'])->setName('mark.media.index');
            $group->get('/create', [MediaController::class, 'create'])->setName('mark.media.create');
            $group->post('', [MediaController::class, 'store'])->setName('mark.media.store');
            $group->get('/{folder}/{filename}', [MediaController::class, 'preview'])->setName('mark.media.preview');
            $group->get('/{id}', [MediaController::class, 'show'])->setName('mark.media.show');
            $group->post('/{id}', [MediaController::class, 'delete'])->setName('mark.media.delete');
        });

        // Media API
        $group->post('/api/media', [MediaController::class, 'apiUpload'])->setName('mark.api.media.upload');
        $group->get('/api/media', [MediaController::class, 'apiList'])->setName('mark.api.media.list');
    })->add($app->getContainer()->get(MarkAuthMiddleware::class));

    // Logout route - outside of the protected group
    $app->get('/mark/logout', [\App\Controllers\Auth\AuthController::class, 'logout'])->setName('mark.logout');

    // Redirect to website - outside of the protected group
    $app->get('/mark/to-website', [\App\Controllers\Mark\RedirectController::class, 'toWebsite'])->setName('mark.to-website');
};
