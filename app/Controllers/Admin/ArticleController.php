<?php

namespace App\Controllers\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Article;

class ArticleController extends AdminController
{
    public function index(Request $request, Response $response): Response
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(20);

        return $this->render($response, 'mark.articles.index', [
            'articles' => $articles
        ]);
    }

    public function create(Request $request, Response $response): Response
    {
        return $this->render($response, 'mark.articles.create');
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $article = Article::create([
            'title' => $data['title'],
            'slug' => $this->createSlug($data['title']),
            'content' => $data['content'],
            'language' => $data['language'],
            'status' => $data['status'] ?? 'draft',
            'user_id' => $request->getAttribute('user')->id
        ]);

        $this->flash('success', 'Article created successfully');
        return $this->redirect($response, '/mark/articles/' . $article->id . '/edit');
    }

    private function createSlug(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $originalSlug = $slug;
        $count = 1;

        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
