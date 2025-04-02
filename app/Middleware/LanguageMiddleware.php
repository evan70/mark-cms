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

    public function __construct()
    {
        $this->defaultLanguage = $_ENV['DEFAULT_LANGUAGE'] ?? 'sk';
        $this->availableLanguages = explode(',', $_ENV['AVAILABLE_LANGUAGES'] ?? 'sk,en,cs');
    }

    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        $pathParts = explode('/', trim($uri, '/'));

        // Get language from URL
        $lang = $pathParts[0] ?? '';

        // If language code is invalid but exists, redirect to default
        if ($lang && !in_array($lang, $this->availableLanguages)) {
            $newUri = '/' . $this->defaultLanguage . substr($uri, strlen($lang) + 1);
            $response = new Response();
            return $response
                ->withHeader('Location', $newUri)
                ->withStatus(302);
        }

        // If no language is specified in the URL, use the default language
        if ($lang === '') {
            $lang = $this->defaultLanguage;
        }

        // Valid language
        return $handler->handle($request->withAttribute('language', $lang));
    }
}
