<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        if (!session('user.id')) {
            // User not logged in, redirect to login
            $response = new \Slim\Psr7\Response();
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/login');
        }
        
        // Refresh last activity timestamp
        session('user.last_activity', time());
        
        return $handler->handle($request);
    }
}