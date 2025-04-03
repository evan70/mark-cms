<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SessionMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        // Always start session with secure defaults
        session_start([
            'cookie_httponly' => true,
            'cookie_secure' => ($_ENV['APP_ENV'] ?? 'development') === 'production',
            'cookie_samesite' => 'Lax',
            'cookie_path' => '/',
            'cookie_domain' => $_ENV['SESSION_DOMAIN'] ?? '',
            'name' => $_ENV['SESSION_NAME'] ?? 'slim_session'
        ]);

        $response = $handler->handle($request);

        // Save and close session
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        return $response;
    }
}
