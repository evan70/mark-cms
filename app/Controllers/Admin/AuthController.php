<?php

namespace App\Controllers\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DI\Container;
use App\Security\Guard;
use App\Models\AdminUser;

class AuthController extends AdminController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function login(Request $request, Response $response): Response
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            $user = AdminUser::where('email', $email)
                ->where('is_active', true)
                ->first();

            if ($user && password_verify($password, $user->password)) {
                $session = $request->getAttribute('session');
                $session->set('admin_user_id', $user->id);
                
                // Update last login
                $user->update(['last_login_at' => now()]);
                
                return $this->redirect($response, '/admin');
            }

            return $this->render($response, 'admin.auth.login', [
                'error' => 'Invalid email or password'
            ]);
        }

        return $this->render($response, 'admin.auth.login');
    }

    public function logout(Request $request, Response $response): Response
    {
        $session = $request->getAttribute('session');
        $session->delete('admin_user_id');
        
        return $response
            ->withHeader('Location', '/admin/login')
            ->withStatus(302);
    }
}
