<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Tag;

class TagController
{
    public function index(Request $request, Response $response): Response
    {
        $tags = Tag::all();

        $response->getBody()->write(json_encode([
            'data' => $tags
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $tag = Tag::where('slug', $args['slug'])->first();

        if (!$tag) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode([
            'data' => $tag
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
