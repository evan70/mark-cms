<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SkipCsrfMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $request = $request->withAttribute('csrf_result', true);
        return $handler->handle($request);
    }
}