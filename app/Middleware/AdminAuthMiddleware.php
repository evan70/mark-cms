<?php

namespace App\Middleware;

use App\Models\AdminUser;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AdminAuthMiddleware
{
    private array $publicPaths = [
        '/admin/login'
    ];

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        
        // Skip auth check for public paths
        if (in_array($path, $this->publicPaths)) {
            return $handler->handle($request);
        }

        // Check if it's an API request
        $isApiRequest = str_starts_with($path, '/api/admin');
        
        if ($isApiRequest) {
            return $this->handleApiAuth($request, $handler);
        }
        
        return $this->handleWebAuth($request, $handler);
    }

    private function handleApiAuth(Request $request, RequestHandler $handler): Response
    {
        $token = $request->getHeaderLine('Authorization');
        
        if (empty($token) || !str_starts_with($token, 'Bearer ')) {
            return $this->unauthorized();
        }

        $token = substr($token, 7);
        
        // Find user by API token
        $user = AdminUser::where('api_token', $token)
            ->where('is_active', true)
            ->first();

        if (!$user) {
            return $this->unauthorized();
        }

        // Add user to request attributes
        return $handler->handle($request->withAttribute('admin_user', $user));
    }

    private function handleWebAuth(Request $request, RequestHandler $handler): Response
    {
        $session = $request->getAttribute('session');
        
        if (!isset($session['admin_user_id'])) {
            return $this->redirectToLogin();
        }

        $user = AdminUser::find($session['admin_user_id']);
        
        if (!$user || !$user->is_active) {
            unset($session['admin_user_id']);
            $request = $request->withAttribute('session', $session);
            return $this->redirectToLogin();
        }

        // Add user to request attributes
        return $handler->handle($request->withAttribute('admin_user', $user));
    }

    private function unauthorized(): Response
    {
        $response = new Response();
        return $response->withStatus(401);
    }

    private function redirectToLogin(): Response
    {
        $response = new Response();
        return $response
            ->withHeader('Location', '/admin/login')
            ->withStatus(302);
    }
}
