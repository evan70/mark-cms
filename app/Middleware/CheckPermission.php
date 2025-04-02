<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class CheckPermission
{
    public function __invoke(Request $request, RequestHandler $handler, string $permission)
    {
        $user = $request->getAttribute('admin_user');
        
        if (!$user || !$user->hasPermission($permission)) {
            $response = new Response();
            return $response->withStatus(403);
        }

        return $handler->handle($request);
    }
}