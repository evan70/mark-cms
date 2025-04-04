<?php

namespace App\Controllers;

use App\Services\ContentService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class ContentController extends BaseController
{
    private $contentService;

    public function __construct(\Psr\Container\ContainerInterface $container, ContentService $contentService)
    {
        parent::__construct($container);
        $this->contentService = $contentService;
    }

    /**
     * Display a listing of articles
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $language = $request->getAttribute('language');
        $category = $request->getQueryParams()['category'] ?? null;

        // Get articles
        $articles = $this->contentService->getArticles([
            'language' => $language
        ], $category);

        // Filter articles by language or get all if no language-specific articles found
        $filteredArticles = array_filter($articles, function($article) use ($language) {
            return ($article['language'] ?? null) === $language;
        });

        // If no articles found for this language, show all
        if (empty($filteredArticles)) {
            $filteredArticles = $articles;
        }

        return $this->render($response, $request, 'content.index', [
            'title' => $category ? ucfirst(str_replace('-', ' ', $category)) : 'Articles',
            'articles' => $filteredArticles,
            'category' => $category,
            'language' => $language,
            'metaDescription' => 'Browse our collection of articles' . ($category ? ' in ' . $category : '')
        ]);
    }

    /**
     * Display the specified article
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $language = $request->getAttribute('language');
        $slug = $args['slug'];
        $category = $request->getQueryParams()['category'] ?? null;

        // Get article
        $article = $this->contentService->getArticle($slug, $category);

        if (!$article) {
            throw new HttpNotFoundException($request);
        }

        // Check if article is for this language or has no language specified
        if (isset($article['language']) && $article['language'] !== $language) {
            // Try to find article in the correct language
            $articlesInCategory = $this->contentService->getArticles([], $category);
            $matchingArticles = array_filter($articlesInCategory, function($a) use ($article, $language) {
                return ($a['slug'] ?? '') === ($article['slug'] ?? '') && ($a['language'] ?? '') === $language;
            });

            if (!empty($matchingArticles)) {
                $article = reset($matchingArticles);
            }
        }

        return $this->render($response, $request, 'content.show', [
            'title' => $article['title'] ?? 'Article',
            'article' => $article,
            'category' => $category,
            'language' => $language,
            'metaDescription' => $article['excerpt'] ?? $article['description'] ?? substr(strip_tags($article['content']), 0, 160),
            'metaKeywords' => implode(', ', $article['tags'] ?? [])
        ]);
    }
}
