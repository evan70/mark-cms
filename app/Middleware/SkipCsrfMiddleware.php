<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SkipCsrfMiddleware
{
    /**
     * Paths that should skip CSRF validation
     *
     * @var array
     */
    protected $paths = [
        '/api/v1',  // Skip CSRF for API routes
        '/mark/api', // Skip CSRF for Mark API routes
        '/switch-lang', // Skip CSRF for language switch
    ];

    /**
     * Check if the current request URI matches any of the whitelisted paths
     *
     * @param string $requestUri
     * @return bool
     */
    protected function shouldSkipCsrf(string $requestUri): bool
    {
        foreach ($this->paths as $path) {
            if (strpos($requestUri, $path) === 0) {
                return true;
            }
        }

        return false;
    }

    public function __invoke(Request $request, RequestHandler $handler)
    {
        $uri = $request->getUri()->getPath();

        if ($this->shouldSkipCsrf($uri)) {
            // Skip CSRF validation for whitelisted paths
            $request = $request->withAttribute('csrf_result', true);
            // Also set a header to indicate CSRF should be skipped
            $request = $request->withHeader('X-Skip-CSRF', 'true');
        }

        return $handler->handle($request);
    }
}