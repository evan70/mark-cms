<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SessionMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        // Get session name from environment
        $sessionName = $_ENV['SESSION_NAME'] ?? 'mark_session';

        // Set session name - must be done before session_start
        if (session_status() === PHP_SESSION_NONE) {
            // Force session name
            session_name($sessionName);

            // Set session parameters
            $sessionParams = [
                'cookie_lifetime' => 0,
                'cookie_httponly' => true,
                'cookie_secure' => filter_var($_ENV['SESSION_SECURE_COOKIE'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'cookie_samesite' => 'Lax',
                'cookie_path' => $_ENV['SESSION_PATH'] ?? '/',
                'cookie_domain' => $_ENV['SESSION_DOMAIN'] ?? ''
            ];

            // Start session with parameters
            session_start($sessionParams);
        }

        $response = $handler->handle($request);

        // Save and close session
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        return $response;
    }
}
