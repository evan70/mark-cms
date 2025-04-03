<?php

namespace App\Controllers;

use App\Models\Article;
use Carbon\Carbon;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArticleController extends BaseController
{
    public function index(Request $request, Response $response): Response
    {
        $language = $request->getAttribute('language');

        $articles = Article::with(['translations' => function($query) use ($language) {
            $query->where('locale', $language);
        }])
        ->where('is_published', true)
        ->where('published_at', '<=', Carbon::now())
        ->orderBy('published_at', 'desc')
        ->get();

        return $this->render($response, $request, 'articles.index', [
            'articles' => $articles,
            'language' => $language
        ]);
    }

    public function detail(Request $request, Response $response, array $args): Response
    {
        $language = $request->getAttribute('language');
        $slug = $args['slug'];

        try {
            $article = Article::with(['translations' => function($query) use ($language) {
                $query->where('locale', $language);
            }])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where('published_at', '<=', Carbon::now())
            ->firstOrFail();

            $translation = $article->translations->first();
            $title = $translation->title ?? 'Article';
            $metaDescription = $translation->meta_description ?? $translation->perex ?? '';

            return $this->render($response, $request, 'articles.detail', [
                'article' => $article,
                'language' => $language,
                'title' => $title,
                'metaDescription' => $metaDescription,
                'metaKeywords' => $translation->meta_keywords ?? ''
            ]);
        } catch (\Exception $e) {
            throw new \Slim\Exception\HttpNotFoundException($request);
        }
    }


}
