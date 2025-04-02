<?php

namespace App\Controllers\Api;

use App\Models\Tag;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TagController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        $lang = $args['lang'];

        $tags = Tag::with(['translations' => function($query) use ($lang) {
            $query->where('locale', $lang);
        }])->get();

        $response->getBody()->write(json_encode([
            'data' => $tags
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $lang = $args['lang'];
        $slug = $args['slug'];

        $tag = Tag::with([
            'translations' => function($query) use ($lang) {
                $query->where('locale', $lang);
            },
            'articles' => function($query) use ($lang) {
                $query->with(['translations' => function($q) use ($lang) {
                    $q->where('locale', $lang);
                }])
                ->where('is_published', true)
                ->whereNotNull('published_at')
                ->orderBy('published_at', 'desc');
            }
        ])
        ->where('slug', $slug)
        ->first();

        if (!$tag) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($response->getBody()->write(json_encode([
                    'error' => 'Tag not found'
                ])));
        }

        $response->getBody()->write(json_encode([
            'data' => $tag
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $tag = Tag::create([
            'slug' => $data['slug']
        ]);

        foreach ($data['translations'] as $locale => $translation) {
            $tag->translations()->create([
                'locale' => $locale,
                'name' => $translation['name']
            ]);
        }

        $response->getBody()->write(json_encode([
            'data' => $tag->load('translations')
        ]));

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $tag = Tag::find($args['id']);

        if (!$tag) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($response->getBody()->write(json_encode([
                    'error' => 'Tag not found'
                ])));
        }

        $data = $request->getParsedBody();

        if (isset($data['slug'])) {
            $tag->update(['slug' => $data['slug']]);
        }

        if (!empty($data['translations'])) {
            foreach ($data['translations'] as $locale => $translation) {
                $tag->translations()->updateOrCreate(
                    ['locale' => $locale],
                    ['name' => $translation['name']]
                );
            }
        }

        $response->getBody()->write(json_encode([
            'data' => $tag->load('translations')
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $tag = Tag::find($args['id']);

        if (!$tag) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($response->getBody()->write(json_encode([
                    'error' => 'Tag not found'
                ])));
        }

        $tag->delete();

        return $response->withStatus(204);
    }
}