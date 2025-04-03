<?php

namespace App\Controllers\Mark;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SettingsController extends BaseController
{
    /**
     * Display the settings page
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        // Get layout preference from session
        $layout = $_SESSION['layout_preference'] ?? 'mark.layouts.app';

        // Set the view based on layout preference
        $view = 'mark.settings';
        if ($layout === 'mark.layouts.side-menu') {
            $view = 'mark.settings-side-menu';
        }

        return $this->render($response, $request, $view, [
            'title' => 'Settings',
            'layout_preference' => $layout
        ]);
    }

    /**
     * Update layout preference
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function updateLayout(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $layout = $data['layout'] ?? 'mark.layouts.app';

        // Validate layout
        if (!in_array($layout, ['mark.layouts.app', 'mark.layouts.side-menu'])) {
            $layout = 'mark.layouts.app';
        }

        // Save preference to session
        $_SESSION['layout_preference'] = $layout;

        return $response
            ->withHeader('Location', '/mark/settings')
            ->withStatus(302);
    }
}
