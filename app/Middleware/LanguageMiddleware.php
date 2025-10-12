<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class LanguageMiddleware
{
    private $defaultLanguage;
    private $availableLanguages;
    private $excludedPaths;

    public function __construct()
    {
        $this->defaultLanguage = $_ENV['DEFAULT_LANGUAGE'] ?? 'sk';
        $this->availableLanguages = explode(',', $_ENV['AVAILABLE_LANGUAGES'] ?? 'sk,en,cs');
        $this->excludedPaths = [
            'mark',
            'login',
            'logout',
            'register',
            'api',
            'css',
            'js',
            'images',
            'fonts'
        ];
    }

    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        $pathParts = explode('/', trim($uri, '/'));

        // Get language from URL
        $lang = $pathParts[0] ?? '';

        // Skip language handling for excluded paths
        if (in_array($lang, $this->excludedPaths)) {
            return $handler->handle($request);
        }

        // If language code is valid, set it in session
        if ($lang && in_array($lang, $this->availableLanguages)) {
            $_SESSION['language'] = $lang;
        } elseif ($lang && !in_array($lang, $this->availableLanguages)) {
            // Invalid language, set to default
            $lang = $this->defaultLanguage;
            $_SESSION['language'] = $lang;
        } elseif ($lang === '') {
            // No language in URL, use session or default
            $lang = $_SESSION['language'] ?? $this->defaultLanguage;
            // If session language is not default and no prefix, redirect to prefixed
            if ($lang !== $this->defaultLanguage) {
                $newUri = '/' . $lang . $uri;
                $response = new Response();
                return $response->withHeader('Location', $newUri)->withStatus(302);
            }
        }

        // Valid language
        return $handler->handle($request->withAttribute('language', $lang));
    }
}
