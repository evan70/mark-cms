<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Services\BladeService;

class ViewMiddleware implements MiddlewareInterface
{
    private BladeService $blade;

    public function __construct(BladeService $blade)
    {
        $this->blade = $blade;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $body = (string) $response->getBody();

        if (strpos($body, 'view:') === 0) {
            $viewData = json_decode(substr($body, 5), true);
            $viewName = $viewData['name'];
            $viewData = $viewData['data'] ?? [];
            
            $renderedView = $this->blade->render($viewName, $viewData);
            
            $response = $response->withHeader('Content-Type', 'text/html');
            $response->getBody()->rewind();
            $response->getBody()->write($renderedView);
        }

        return $response;
    }
}
