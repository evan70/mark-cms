
<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;

return function($app) {
    $app->get('/debug/session', function (Request $request, Response $response) use ($app) {
        $session = session();
        $logger = $app->getContainer()->get(LoggerInterface::class);
        
        // Increment visit counter
        $visits = $session->get('visits', 0) + 1;
        $session->set('visits', $visits);
        
        // Add timestamp for last visit
        $session->set('last_visit', time());
        
        // Log the session access
        $logger->info('Session accessed', [
            'session_id' => $session::id(),
            'visits' => $visits,
            'ip' => $request->getServerParams()['REMOTE_ADDR'] ?? 'unknown'
        ]);
        
        $response->getBody()->write(json_encode([
            'session_info' => [
                'id' => $session::id(),
                'name' => session_name(),
                'expires' => session_cache_expire(),
                'last_visit' => date('Y-m-d H:i:s', $session->get('last_visit')),
            ],
            'visit_counter' => [
                'visits' => $visits,
                'first_visit' => $session->get('first_visit', date('Y-m-d H:i:s')),
            ],
            'session_data' => $_SESSION,
            'cookie_params' => session_get_cookie_params()
        ], JSON_PRETTY_PRINT));
        
        return $response->withHeader('Content-Type', 'application/json');
    });
};
