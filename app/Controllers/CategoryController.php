<?php

namespace App\Controllers;

use App\Models\Category;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoryController extends BaseController
{
    public function list(Request $request, Response $response): Response
    {
        $language = $request->getAttribute('language');
        
        $categories = Category::with(['translations' => function($query) use ($language) {
            $query->where('locale', $language);
        }])
        ->orderBy('id', 'asc')
        ->get();
        
        return $this->render($response, $request, 'categories.list', [
            'categories' => $categories,
            'language' => $language
        ]);
    }

    public function detail(Request $request, Response $response, array $args): Response
    {
        $language = $request->getAttribute('language');
        $slug = $args['slug'];
        
        $category = Category::with([
            'translations' => function($query) use ($language) {
                $query->where('locale', $language);
            },
            'articles' => function($query) use ($language) {
                $query->with(['translations' => function($q) use ($language) {
                    $q->where('locale', $language);
                }]);
            }
        ])
        ->where('slug', $slug)
        ->firstOrFail();
        
        $translation = $category->translations->first();
        
        if (!$translation) {
            throw new \Slim\Exception\HttpNotFoundException($request);
        }
        
        return $this->render($response, $request, 'categories.detail', [
            'category' => $category,
            'translation' => $translation,
            'language' => $language
        ]);
    }
}
