<?php

namespace App\Controllers\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Article;
use App\Models\Language;

class DashboardController extends AdminController
{
    public function index(Request $request, Response $response): Response
    {
        $stats = [
            'articles' => Article::count(),
            'languages' => Language::where('is_active', true)->count(),
        ];

        return $this->render($response, 'mark.dashboard', [
            'title' => 'Dashboard',
            'stats' => $stats
        ]);
    }
}
