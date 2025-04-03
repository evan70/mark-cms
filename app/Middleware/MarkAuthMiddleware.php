<?php

namespace App\Middleware;

use App\Services\Auth\MarkAuthService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class MarkAuthMiddleware
{
    /**
     * @var MarkAuthService
     */
    private MarkAuthService $authService;

    /**
     * @var array
     */
    private array $publicPaths = [
        '/mark/login',
        '/mark/password/reset',
        '/mark/password/email',
        '/mark/password/reset/{token}',
    ];

    /**
     * MarkAuthMiddleware constructor.
     *
     * @param MarkAuthService $authService
     */
    public function __construct(MarkAuthService $authService)
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

        // Check if mark user is authenticated
        if (!$this->authService->check()) {
            return $this->redirectToLogin();
        }

        // Get the mark user
        $user = $this->authService->user();

        if (!$user || !$user->isActive()) {
            $this->authService->logout();
            return $this->redirectToLogin();
        }

        // Check if the path starts with /mark/admin and the user has admin access
        if (strpos($path, '/mark/admin') === 0 && !$user->hasAdminAccess()) {
            return $this->forbidden();
        }

        // Add mark user to request attributes
        return $handler->handle($request->withAttribute('mark_user', $user));
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
            ->withHeader('Location', '/login?mark=1')
            ->withStatus(302);
    }

    /**
     * Return forbidden response
     *
     * @return Response
     */
    private function forbidden(): Response
    {
        $response = new Response();
        return $response->withStatus(403);
    }
}
