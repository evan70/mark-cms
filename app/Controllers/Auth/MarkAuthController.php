<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Services\Auth\MarkAuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MarkAuthController extends BaseController
{
    /**
     * @var MarkAuthService
     */
    private MarkAuthService $authService;

    /**
     * MarkAuthController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService = $container->get(MarkAuthService::class);
    }

    /**
     * Show login form
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showLoginForm(Request $request, Response $response): Response
    {
        return $this->render($response, $request, 'auth.login', [
            'title' => 'Mark CMS Login'
        ]);
    }

    /**
     * Handle login
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function login(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $user = $this->authService->attempt($email, $password);

        if (!$user) {
            return $this->render($response, $request, 'auth.login', [
                'title' => 'Mark CMS Login',
                'error' => 'Invalid credentials',
                'email' => $email
            ]);
        }

        $this->authService->login($request, $user);

        // Redirect to mark dashboard for all users
        return $response
            ->withHeader('Location', '/mark')
            ->withStatus(302);
    }

    /**
     * Handle logout
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function logout(Request $request, Response $response): Response
    {
        $this->authService->logout();

        return $response
            ->withHeader('Location', '/mark/login')
            ->withStatus(302);
    }

    /**
     * Show dashboard
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function dashboard(Request $request, Response $response): Response
    {
        $user = $this->authService->user();

        return $this->render($response, $request, 'mark.dashboard', [
            'title' => 'Mark CMS Dashboard',
            'user' => $user
        ]);
    }

    /**
     * Show admin dashboard
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function adminDashboard(Request $request, Response $response): Response
    {
        $user = $this->authService->user();

        if (!$user->hasAdminAccess()) {
            return $response->withStatus(403);
        }

        return $this->render($response, $request, 'mark.admin.dashboard', [
            'title' => 'Mark CMS Admin Dashboard',
            'user' => $user
        ]);
    }
}
