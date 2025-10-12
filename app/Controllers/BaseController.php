<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\BladeService;
use App\Services\MetaService;

abstract class BaseController
{
    protected $container;
    protected $blade;
    protected $metaService;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->blade = $container->get(BladeService::class);
        $this->metaService = $container->get(MetaService::class);
    }

    protected function render(Response $response, Request $request, string $template, array $data = []): Response
    {
        $baseUrl = rtrim($_ENV['APP_URL'], '/');

        // Generate meta data
        $data = $this->metaService->generateMeta($data);

        // Share language globally for layout
        if (isset($data['language'])) {
            $this->blade->share('language', $data['language']);
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
