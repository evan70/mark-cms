<?php

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use App\Bootstrap\AppBootstrap;

class WebRoutesTest extends TestCase
{
    private $app;

    protected function setUp(): void
    {
        // Initialize the Slim app for testing
        $this->app = AppBootstrap::createApp();
    }

    public function testHomeRoute()
    {
        $request = $this->createRequest('GET', '/');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCategoriesRoute()
    {
        $request = $this->createRequest('GET', '/categories');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testArticlesRoute()
    {
        $request = $this->createRequest('GET', '/articles');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testSearchRoute()
    {
        $request = $this->createRequest('GET', '/search');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testContentRoute()
    {
        $request = $this->createRequest('GET', '/content');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLanguagePrefixedHomeRoute()
    {
        $request = $this->createRequest('GET', '/en/');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLanguagePrefixedCategoriesRoute()
    {
        $request = $this->createRequest('GET', '/en/categories');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLanguagePrefixedArticlesRoute()
    {
        $request = $this->createRequest('GET', '/en/articles');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLanguagePrefixedSearchRoute()
    {
        $request = $this->createRequest('GET', '/en/search');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLanguagePrefixedContentRoute()
    {
        $request = $this->createRequest('GET', '/en/content');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testInvalidRouteReturns404()
    {
        $request = $this->createRequest('GET', '/invalid-route');
        $response = $this->app->handle($request);

        $this->assertEquals(404, $response->getStatusCode());
    }

    private function createRequest(string $method, string $path): Request
    {
        $uri = (new \Slim\Psr7\Factory\UriFactory())->createUri($path);
        return (new \Slim\Psr7\Factory\ServerRequestFactory())->createServerRequest($method, $uri);
    }
}
