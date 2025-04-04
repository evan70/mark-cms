<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\SearchService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SearchController extends BaseController
{
    private $searchService;

    public function __construct(\Psr\Container\ContainerInterface $container, SearchService $searchService)
    {
        parent::__construct($container);
        $this->searchService = $searchService;
    }

    /**
     * Display search results
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $query = $request->getQueryParams()['q'] ?? '';
        $results = [];

        if (!empty($query)) {
            $results = $this->searchService->search($query);
        }

        return $this->render($response, $request, 'search/results', [
            'title' => 'Search Results',
            'query' => $query,
            'results' => $results,
            'language' => $request->getAttribute('language') ?? config('app.default_language', 'sk'),
        ]);
    }
}
