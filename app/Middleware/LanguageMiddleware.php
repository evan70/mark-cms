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

        // If language code is invalid but exists, set to default (no redirect)
        if ($lang && !in_array($lang, $this->availableLanguages)) {
            $lang = $this->defaultLanguage;
        }

        // If no language is specified in the URL, use the default language
        if ($lang === '') {
            $lang = $this->defaultLanguage;
        }

        // Valid language
        return $handler->handle($request->withAttribute('language', $lang));
    }
}
