<?php

namespace App\Controllers\Mark;

use Psr\Http\Message\ResponseInterface as Response;
use Mezzio\Session\Session;

abstract class AdminController
{
    protected function render(Response $response, string $template, array $data = []): Response
    {
        // Add default admin data
        $data = array_merge([
            'title' => 'Admin Panel',
            'user' => session('user'),
            'flash' => session()->getFlashMessages()
        ], $data);

        $contents = $this->view->make($template)
            ->with($data)
            ->extends('admin.layouts.admin')
            ->render();
            
        $response->getBody()->write($contents);
        return $response;
    }

    protected function redirect(Response $response, string $url, int $status = 302): Response
    {
        return $response
            ->withHeader('Location', $url)
            ->withStatus($status);
    }

    protected function setFlashMessage(string $type, string $message): void
    {
        session()->flash($type, $message);
    }
}
