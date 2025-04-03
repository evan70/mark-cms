<?php

use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\MarkAuthController;
use App\Middleware\UserAuthMiddleware;
use App\Middleware\MarkAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Regular user authentication routes
    $app->group('', function (RouteCollectorProxy $group) {
        // Login routes
        $group->get('/login', [AuthController::class, 'showLoginForm'])->setName('login');
        $group->post('/login', [AuthController::class, 'login']);

        // Registration routes
        $group->get('/register', [AuthController::class, 'showRegistrationForm'])->setName('register');
        $group->post('/register', [AuthController::class, 'register']);

        // Logout route
        $group->get('/logout', [AuthController::class, 'logout'])->setName('logout');
    });

    // Mark CMS authentication routes
    // Login route is now handled by AuthController
    // Logout route for Mark CMS is defined in routes/mark.php

    // Protected Mark CMS routes
    $app->group('/mark', function (RouteCollectorProxy $group) {
        // Dashboard
        $group->get('/dashboard', [MarkAuthController::class, 'dashboard'])->setName('mark.dashboard');
    })->add($app->getContainer()->get(MarkAuthMiddleware::class));

    // Protected Admin routes for mark_users with admin role
    $app->group('/mark/admin', function (RouteCollectorProxy $group) {
        // Admin Dashboard
        $group->get('/dashboard', [MarkAuthController::class, 'adminDashboard'])->setName('mark.admin.dashboard');
    })->add($app->getContainer()->get(MarkAuthMiddleware::class));
};
