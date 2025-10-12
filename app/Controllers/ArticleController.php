<?php

namespace App\Controllers;

use App\Models\Article;
use App\Services\ArticleService;
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArticleController extends BaseController
{
    private ArticleService $articleService;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->articleService = $this->container->get(ArticleService::class);
    }
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

        $data = $this->articleService->getArticleData($slug, $language);

        if (!$data) {
            throw new \Slim\Exception\HttpNotFoundException($request);
        }

        return $this->render($response, $request, 'articles.detail', array_merge($data, ['language' => $language]));
    }


}
