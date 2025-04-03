<?php

namespace App\Middleware;

use App\Services\Auth\AuthService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class UserAuthMiddleware
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * @var array
     */
    private array $publicPaths = [
        '/login',
        '/register',
        '/password/reset',
        '/password/email',
        '/password/reset/{token}',
        '/verify-email/{id}/{hash}',
    ];

    /**
     * UserAuthMiddleware constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Invoke middleware
     *
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        
        // Skip auth check for public paths
        foreach ($this->publicPaths as $publicPath) {
            if ($this->pathMatches($path, $publicPath)) {
                return $handler->handle($request);
            }
        }

        // Check if user is authenticated
        if (!$this->authService->check()) {
            return $this->redirectToLogin();
        }

        // Get the user
        $user = $this->authService->user();
        
        if (!$user || !$user->isActive()) {
            $this->authService->logout();
            return $this->redirectToLogin();
        }

        // Add user to request attributes
        return $handler->handle($request->withAttribute('user', $user));
    }

    /**
     * Check if a path matches a pattern
     *
     * @param string $path
     * @param string $pattern
     * @return bool
     */
    private function pathMatches(string $path, string $pattern): bool
    {
        // Convert pattern to regex
        $pattern = preg_quote($pattern, '/');
        $pattern = str_replace('\{[^\/]+\}', '[^\/]+', $pattern);
        
        return (bool) preg_match('/^' . $pattern . '$/', $path);
    }

    /**
     * Redirect to login page
     *
     * @return Response
     */
    private function redirectToLogin(): Response
    {
        $response = new Response();
        return $response
            ->withHeader('Location', '/login')
            ->withStatus(302);
    }
}
