<?php

namespace App\Controllers;

use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends BaseController
{
    public function index(Request $request, Response $response): Response
    {
        // Check if user is logged in as mark_user
        if (isset($_SESSION['mark_user_id'])) {
            // Redirect to mark dashboard
            return $response
                ->withHeader('Location', '/mark')
                ->withStatus(302);
        }

        // Get language from URL or use default
        $language = $request->getAttribute('language') ?? $_ENV['DEFAULT_LANGUAGE'];

        // Get latest articles
        $latestArticles = Article::with(['translations' => function($query) use ($language) {
            $query->where('locale', $language);
        }])
        ->where('is_published', true)
        ->where('published_at', '<=', Carbon::now())
        ->orderBy('published_at', 'desc')
        ->limit(3)
        ->get();

        // Get categories
        $categories = Category::with(['translations' => function($query) use ($language) {
            $query->where('locale', $language);
        }])
        ->orderBy('id', 'asc')
        ->get();

        return $this->render($response, $request, 'home', [
            'latestArticles' => $latestArticles,
            'categories' => $categories,
            'language' => $language
        ]);
    }
}
