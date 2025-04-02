<?php

namespace App\Controllers\Api;

use App\Models\Article;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArticleController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        $lang = $args['lang'];
        $page = $request->getQueryParams()['page'] ?? 1;
        $perPage = $request->getQueryParams()['per_page'] ?? 20;

        $articles = Article::with(['translations' => function($query) use ($lang) {
            $query->where('locale', $lang);
        }])
        ->where('is_published', true)
        ->whereNotNull('published_at')
        ->orderBy('published_at', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);

        $formattedArticles = $articles->items()->map(function ($article) {
            $translation = $article->translations->first();
            return [
                'id' => $article->id,
                'slug' => $article->slug,
                'title' => $translation ? $translation->title : null,
                'perex' => $translation ? $translation->perex : null,
                'featured_image' => $article->featured_image,
                'published_at' => $article->published_at
            ];
        });

        $response->getBody()->write(json_encode([
            'data' => $formattedArticles,
            'meta' => [
                'current_page' => $articles->currentPage(),
                'total' => $articles->total(),
                'per_page' => $articles->perPage()
            ]
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $lang = $args['lang'];
        $slug = $args['slug'];

        $article = Article::with(['translations' => function($query) use ($lang) {
            $query->where('locale', $lang);
        }])
        ->where('slug', $slug)
        ->where('is_published', true)
        ->whereNotNull('published_at')
        ->first();

        if (!$article) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($response->getBody()->write(json_encode([
                    'error' => 'Article not found'
                ])));
        }

        $response->getBody()->write(json_encode([
            'data' => $article
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        // Validate input
        if (empty($data['translations'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($response->getBody()->write(json_encode([
                    'error' => 'Translations are required'
                ])));
        }

        $article = Article::create([
            'slug' => \Str::slug($data['translations']['en']['title']),
            'is_published' => $data['is_published'] ?? false,
            'published_at' => $data['published_at'] ?? null
        ]);

        foreach ($data['translations'] as $locale => $translation) {
            $article->translations()->create([
                'locale' => $locale,
                'title' => $translation['title'],
                'perex' => $translation['perex'] ?? null,
                'content' => $translation['content'],
                'meta_title' => $translation['meta_title'] ?? null,
                'meta_description' => $translation['meta_description'] ?? null
            ]);
        }

        $response->getBody()->write(json_encode([
            'data' => $article->load('translations')
        ]));

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $article = Article::find($args['id']);

        if (!$article) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($response->getBody()->write(json_encode([
                    'error' => 'Article not found'
                ])));
        }

        $data = $request->getParsedBody();

        $article->update([
            'is_published' => $data['is_published'] ?? $article->is_published,
            'published_at' => $data['published_at'] ?? $article->published_at
        ]);

        if (!empty($data['translations'])) {
            foreach ($data['translations'] as $locale => $translation) {
                $article->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'title' => $translation['title'],
                        'perex' => $translation['perex'] ?? null,
                        'content' => $translation['content'],
                        'meta_title' => $translation['meta_title'] ?? null,
                        'meta_description' => $translation['meta_description'] ?? null
                    ]
                );
            }
        }

        $response->getBody()->write(json_encode([
            'data' => $article->load('translations')
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $article = Article::find($args['id']);

        if (!$article) {
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($response->getBody()->write(json_encode([
                    'error' => 'Article not found'
                ])));
        }

        $article->delete();

        return $response->withStatus(204);
    }
}
