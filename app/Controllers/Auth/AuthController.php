<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Services\Auth\AuthService;
use App\Services\Auth\MarkAuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends BaseController
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * @var MarkAuthService
     */
    private MarkAuthService $markAuthService;

    /**
     * AuthController constructor.
     *
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService = $container->get(AuthService::class);
        $this->markAuthService = $container->get(MarkAuthService::class);
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
        // Check if this is a mark login request
        $queryParams = $request->getQueryParams();
        $isMarkLogin = isset($queryParams['mark']) && $queryParams['mark'] === '1';

        if ($isMarkLogin) {
            return $this->render($response, $request, 'auth.login', [
                'title' => 'Mark CMS Login',
                'isMarkLogin' => true
            ]);
        }

        return $this->render($response, $request, 'auth.login', [
            'title' => 'Login'
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
        $isMarkLogin = isset($data['is_mark_login']) && $data['is_mark_login'] === '1';

        if ($isMarkLogin) {
            // Try to authenticate as mark user
            $user = $this->markAuthService->attempt($email, $password);

            if (!$user) {
                return $this->render($response, $request, 'auth.login', [
                    'title' => 'Mark CMS Login',
                    'error' => 'Invalid credentials',
                    'email' => $email,
                    'isMarkLogin' => true
                ]);
            }

            $this->markAuthService->login($request, $user);

            // Redirect to admin dashboard if user has admin access
            if ($user->hasAdminAccess()) {
                return $response
                    ->withHeader('Location', '/mark/admin/dashboard')
                    ->withStatus(302);
            }

            // Redirect to mark dashboard for contributors
            return $response
                ->withHeader('Location', '/mark/dashboard')
                ->withStatus(302);
        } else {
            // Try to authenticate as regular user
            $user = $this->authService->attempt($email, $password);

            if (!$user) {
                return $this->render($response, $request, 'auth.login', [
                    'title' => 'Login',
                    'error' => 'Invalid credentials',
                    'email' => $email
                ]);
            }

            $this->authService->login($request, $user);

            return $response
                ->withHeader('Location', '/')
                ->withStatus(302);
        }
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
            ->withHeader('Location', '/')
            ->withStatus(302);
    }

    /**
     * Show registration form
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showRegistrationForm(Request $request, Response $response): Response
    {
        return $this->render($response, $request, 'auth.register', [
            'title' => 'Register'
        ]);
    }

    /**
     * Handle registration
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        // Validate data
        $errors = $this->validateRegistration($data);

        if (!empty($errors)) {
            return $this->render($response, $request, 'auth.register', [
                'title' => 'Register',
                'errors' => $errors,
                'data' => $data
            ]);
        }

        // Register user
        $user = $this->authService->register([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'is_active' => true
        ]);

        // Log in the user
        $this->authService->login($request, $user);

        return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
    }

    /**
     * Validate registration data
     *
     * @param array $data
     * @return array
     */
    private function validateRegistration(array $data): array
    {
        $errors = [];

        // Validate name
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }

        // Validate email
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email is invalid';
        }

        // Validate password
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < 8) {
            $errors['password'] = 'Password must be at least 8 characters';
        }

        // Validate password confirmation
        if (empty($data['password_confirmation'])) {
            $errors['password_confirmation'] = 'Password confirmation is required';
        } elseif ($data['password'] !== $data['password_confirmation']) {
            $errors['password_confirmation'] = 'Password confirmation does not match';
        }

        return $errors;
    }
}
