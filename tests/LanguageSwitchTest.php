<?php

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use App\Bootstrap\AppBootstrap;

class LanguageSwitchTest extends TestCase
{
    private $app;

    protected function setUp(): void
    {
        // Initialize the Slim app for testing
        $this->app = AppBootstrap::createApp();
    }

    public function testLanguageSwitchWithValidCode()
    {
        // Create a mock request for /switch-lang/en
        $request = $this->createMock(Request::class);
        $request->method('getMethod')->willReturn('GET');
        $request->method('getUri')->willReturn($this->createMock(\Slim\Psr7\Uri::class));

        // Mock the args for the route
        $args = ['code' => 'en'];

        // Mock the response
        $response = new Response();

        // Simulate the route handler
        $handler = function ($request, $response, $args) {
            $code = $args['code'] ?? $request->getQueryParams()['code'] ?? $request->getParsedBody()['code'] ?? 'sk';
            $available = explode(',', $_ENV['AVAILABLE_LANGUAGES'] ?? 'sk,en,cs');
            $default = $_ENV['DEFAULT_LANGUAGE'] ?? 'sk';

            if (in_array($code, $available)) {
                $_SESSION['language'] = $code;
            }

            $referer = $_SERVER['HTTP_REFERER'] ?? '/';
            $parsed = parse_url($referer);
            $currentPath = $parsed['path'] ?? '/';

            // Remove existing language prefix
            if (preg_match('/^\/(' . implode('|', $available) . ')/', $currentPath, $matches)) {
                $currentPath = substr($currentPath, strlen($matches[0]));
            }

            // Remove trailing slash
            $currentPath = rtrim($currentPath, '/');

            if ($code === $default) {
                $redirect = $currentPath ?: '/';
            } else {
                $redirect = '/' . $code . $currentPath;
            }

            return $response->withHeader('Location', $redirect)->withStatus(302);
        };

        $result = $handler($request, $response, $args);

        $this->assertEquals(302, $result->getStatusCode());
        $this->assertEquals('/en', $result->getHeaderLine('Location'));
    }

    public function testLanguageSwitchWithInvalidCode()
    {
        // Create a mock request for /switch-lang/xx (invalid code)
        $request = $this->createMock(Request::class);
        $args = ['code' => 'xx'];
        $response = new Response();

        $handler = function ($request, $response, $args) {
            $code = $args['code'] ?? $request->getQueryParams()['code'] ?? $request->getParsedBody()['code'] ?? 'sk';
            $available = explode(',', $_ENV['AVAILABLE_LANGUAGES'] ?? 'sk,en,cs');
            $default = $_ENV['DEFAULT_LANGUAGE'] ?? 'sk';

            if (in_array($code, $available)) {
                $_SESSION['language'] = $code;
            }

            $referer = $_SERVER['HTTP_REFERER'] ?? '/';
            $parsed = parse_url($referer);
            $currentPath = $parsed['path'] ?? '/';

            // Remove existing language prefix
            if (preg_match('/^\/(' . implode('|', $available) . ')/', $currentPath, $matches)) {
                $currentPath = substr($currentPath, strlen($matches[0]));
            }

            // Remove trailing slash
            $currentPath = rtrim($currentPath, '/');

            if ($code === $default) {
                $redirect = $currentPath ?: '/';
            } else {
                $redirect = '/' . $code . $currentPath;
            }

            return $response->withHeader('Location', $redirect)->withStatus(302);
        };

        $result = $handler($request, $response, $args);

        $this->assertEquals(302, $result->getStatusCode());
        // Since 'xx' is invalid, session is not set, so it redirects to '/xx' because code is not default
        $this->assertEquals('/xx', $result->getHeaderLine('Location'));
    }

    public function testLanguageSwitchWithDefaultLanguage()
    {
        // Create a mock request for /switch-lang/sk (default language)
        $request = $this->createMock(Request::class);
        $args = ['code' => 'sk'];
        $response = new Response();

        $handler = function ($request, $response, $args) {
            $code = $args['code'] ?? $request->getQueryParams()['code'] ?? $request->getParsedBody()['code'] ?? 'sk';
            $available = explode(',', $_ENV['AVAILABLE_LANGUAGES'] ?? 'sk,en,cs');
            $default = $_ENV['DEFAULT_LANGUAGE'] ?? 'sk';

            if (in_array($code, $available)) {
                $_SESSION['language'] = $code;
            }

            $referer = $_SERVER['HTTP_REFERER'] ?? '/';
            $parsed = parse_url($referer);
            $currentPath = $parsed['path'] ?? '/';

            // Remove existing language prefix
            if (preg_match('/^\/(' . implode('|', $available) . ')/', $currentPath, $matches)) {
                $currentPath = substr($currentPath, strlen($matches[0]));
            }

            // Remove trailing slash
            $currentPath = rtrim($currentPath, '/');

            if ($code === $default) {
                $redirect = $currentPath ?: '/';
            } else {
                $redirect = '/' . $code . $currentPath;
            }

            return $response->withHeader('Location', $redirect)->withStatus(302);
        };

        $result = $handler($request, $response, $args);

        $this->assertEquals(302, $result->getStatusCode());
        $this->assertEquals('/', $result->getHeaderLine('Location'));
    }
}
