<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class StaticAssetsMiddleware implements MiddlewareInterface
{
    private array $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
    ];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        
        // Remove query string for versioned assets
        $uri = preg_replace('/\?.*/', '', $uri);
        
        if (strpos($uri, '/assets/') === 0) {
            $filePath = dirname(__DIR__, 2) . '/public' . $uri;
            
            if (file_exists($filePath)) {
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                $mimeType = $this->mimeTypes[$extension] ?? 'text/plain';
                
                $response = new Response();
                $response = $response->withHeader('Content-Type', $mimeType);
                $response = $response->withHeader('Cache-Control', 'public, max-age=31536000');
                $response->getBody()->write(file_get_contents($filePath));
                
                return $response;
            }
        }

        return $handler->handle($request);
    }
}
