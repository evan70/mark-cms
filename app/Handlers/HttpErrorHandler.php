<?php

namespace App\Handlers;

use Psr\Http\Message\ResponseInterface;
use Slim\Handlers\ErrorHandler;
use App\Services\BladeService;
use Throwable;

class HttpErrorHandler extends ErrorHandler
{
    private $blade;

    public function __construct($callableResolver, $responseFactory, BladeService $blade)
    {
        parent::__construct($callableResolver, $responseFactory);
        $this->blade = $blade;
    }

    protected function respond(): ResponseInterface
    {
        $exception = $this->exception;
        $request = $this->request;
        $statusCode = 500;
        $error = [
            'message' => $exception->getMessage()
        ];

        if ($exception instanceof \Slim\Exception\HttpException) {
            $statusCode = $exception->getCode();
        }

        $response = $this->responseFactory->createResponse();
        try {
            // Try to render the simple error page
            $response->getBody()->write($this->blade->render('errors/simple', [
                'error' => $error,
                'statusCode' => $statusCode,
                'title' => $statusCode . ' - ' . $this->getErrorTitle($statusCode),
                'language' => $request->getAttribute('language') ?? config('app.default_language', 'sk')
            ]));
        } catch (\Exception $e) {
            // Fallback to very simple error page if rendering fails
            $response->getBody()->write('<html><body><h1>Error ' . $statusCode . '</h1><p>' . $error['message'] . '</p></body></html>');
        }

        return $response->withStatus($statusCode);
    }

    /**
     * Get error title based on status code
     *
     * @param int $statusCode
     * @return string
     */
    private function getErrorTitle(int $statusCode): string
    {
        switch ($statusCode) {
            case 401:
                return 'Unauthorized';
            case 403:
                return 'Access Denied';
            case 404:
                return 'Page Not Found';
            case 500:
                return 'Server Error';
            default:
                return 'Error';
        }
    }
}
