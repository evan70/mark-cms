<?php

namespace App\Controllers\Api;

use App\Models\Category;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoryController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        $lang = $args['lang'];

        $categories = Category::with(['translations' => function($query) use ($lang) {
            $query->where('locale', $lang);
        }])->get();

        $response->getBody()->write(json_encode([
            'data' => $categories
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $lang = $args['lang'];
        $slug = $args['slug'];

        $category = Category::with([
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

        if (!$category) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($response->getBody()->write(json_encode([
                    'error' => 'Category not found'
                ])));
        }

        $response->getBody()->write(json_encode([
            'data' => $category
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $category = Category::create([
            'slug' => $data['slug']
        ]);

        foreach ($data['translations'] as $locale => $translation) {
            $category->translations()->create([
                'locale' => $locale,
                'name' => $translation['name'],
                'description' => $translation['description'] ?? null,
                'meta_title' => $translation['meta_title'] ?? null,
                'meta_description' => $translation['meta_description'] ?? null
            ]);
        }

        $response->getBody()->write(json_encode([
            'data' => $category->load('translations')
        ]));

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $category = Category::find($args['id']);

        if (!$category) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($response->getBody()->write(json_encode([
                    'error' => 'Category not found'
                ])));
        }

        $data = $request->getParsedBody();

        if (isset($data['slug'])) {
            $category->update(['slug' => $data['slug']]);
        }

        if (!empty($data['translations'])) {
            foreach ($data['translations'] as $locale => $translation) {
                $category->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'name' => $translation['name'],
                        'description' => $translation['description'] ?? null,
                        'meta_title' => $translation['meta_title'] ?? null,
                        'meta_description' => $translation['meta_description'] ?? null
                    ]
                );
            }
        }

        $response->getBody()->write(json_encode([
            'data' => $category->load('translations')
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $category = Category::find($args['id']);

        if (!$category) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($response->getBody()->write(json_encode([
                    'error' => 'Category not found'
                ])));
        }

        $category->delete();

        return $response->withStatus(204);
    }
}