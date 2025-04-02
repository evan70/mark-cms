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
        $statusCode = 500;
        $error = [
            'message' => $exception->getMessage()
        ];

        if ($exception instanceof \Slim\Exception\HttpException) {
            $statusCode = $exception->getCode();
        }

        $response = $this->responseFactory->createResponse();
        $response->getBody()->write($this->blade->render('errors/' . $statusCode, [
            'error' => $error
        ]));

        return $response->withStatus($statusCode);
    }
}
