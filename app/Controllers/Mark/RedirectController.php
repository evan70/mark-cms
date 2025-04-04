<?php

namespace App\Controllers\Mark;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RedirectController
{
    /**
     * Redirect to website
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function toWebsite(Request $request, Response $response): Response
    {
        // Get language from session or default to 'sk'
        $language = $_SESSION['language'] ?? 'sk';
        
        // Redirect to website
        return $response
            ->withHeader('Location', '/' . $language)
            ->withStatus(302);
    }
}
