<?php

declare(strict_types=1);

namespace App\Providers;

class SessionProvider
{
    public static function boot(): void
    {
        // Set session name before any session is started
        $sessionName = $_ENV['SESSION_NAME'] ?? 'mark_session';
        ini_set('session.name', $sessionName);
        session_name($sessionName);

        // Start session with parameters
        session_start([
            'cookie_lifetime' => 0,
            'cookie_httponly' => true,
            'cookie_secure' => (bool)($_ENV['SESSION_SECURE_COOKIE'] ?? false),
            'cookie_samesite' => 'Lax',
            'cookie_path' => $_ENV['SESSION_PATH'] ?? '/',
            'cookie_domain' => $_ENV['SESSION_DOMAIN'] ?? ''
        ]);
    }
}
