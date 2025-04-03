<?php

namespace App\Controllers\Mark;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Article;
use App\Models\Language;
use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index(Request $request, Response $response): Response
    {
        // Get current user from session
        $userId = $_SESSION['mark_user_id'] ?? null;
        $user = null;

        if ($userId) {
            $user = \App\Models\MarkUser::find($userId);
        }

        if (!$user) {
            return $response->withHeader('Location', '/login?mark=1')->withStatus(302);
        }

        $stats = [
            'articles' => Article::count(),
            'languages' => Language::where('is_active', true)->count(),
        ];

        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the layout in the view data
        $view = 'mark.dashboard';

        // If using side-menu layout, use that template
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.dashboard-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Dashboard',
            'stats' => $stats,
            'user' => $user
        ]);
    }
}
