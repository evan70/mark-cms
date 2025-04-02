<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\BladeService;

abstract class BaseController
{
    protected $container;
    protected $blade;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->blade = $container->get(BladeService::class);
    }

    protected function render(Response $response, Request $request, string $template, array $data = []): Response
    {
        $baseUrl = rtrim($_ENV['APP_URL'], '/');

        // Add meta description and keywords if not provided
        if (!isset($data['metaDescription']) && isset($data['title'])) {
            $data['metaDescription'] = $data['title'] . ' - ' . config('app.description');
        }

        if (!isset($data['metaKeywords']) && isset($data['title'])) {
            // Add title keywords to default keywords
            $titleWords = preg_replace('/[^a-zA-Z0-9\s]/', '', $data['title']);
            $titleKeywords = strtolower(str_replace(' ', ', ', $titleWords));
            $data['metaKeywords'] = $titleKeywords . ', ' . config('app.meta_keywords');
        }

        // Merge base data with provided data
        $viewData = array_merge([
            'baseUrl' => $baseUrl,
            // other default data...
        ], $data);

        $content = $this->blade->render($template, $viewData);
        $response->getBody()->write($content);

        return $response;
    }
}
