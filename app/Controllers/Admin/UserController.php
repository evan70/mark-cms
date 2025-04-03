<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends BaseController
{
    /**
     * Display a listing of users
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $users = User::orderBy('created_at', 'desc')->get();

        return $this->render($response, $request, 'mark.users.index', [
            'title' => 'Users',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new user
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        return $this->render($response, $request, 'mark.users.create', [
            'title' => 'Create User'
        ]);
    }

    /**
     * Store a newly created user
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        // Validate data
        $errors = $this->validateUser($data);

        if (!empty($errors)) {
            return $this->render($response, $request, 'mark.users.create', [
                'title' => 'Create User',
                'errors' => $errors,
                'data' => $data
            ]);
        }

        // Create user
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'is_active' => isset($data['is_active']) && $data['is_active'] === '1',
            'email_verified_at' => isset($data['email_verified']) && $data['email_verified'] === '1' ? now() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $response
            ->withHeader('Location', '/mark/users')
            ->withStatus(302);
    }

    /**
     * Show the form for editing the specified user
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function edit(Request $request, Response $response, array $args): Response
    {
        $user = User::find($args['id']);

        if (!$user) {
            return $response->withStatus(404);
        }

        return $this->render($response, $request, 'mark.users.edit', [
            'title' => 'Edit User',
            'user' => $user
        ]);
    }

    /**
     * Update the specified user
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        $user = User::find($args['id']);

        if (!$user) {
            return $response->withStatus(404);
        }

        $data = $request->getParsedBody();

        // Validate data
        $errors = $this->validateUser($data, $user->id);

        if (!empty($errors)) {
            return $this->render($response, $request, 'mark.users.edit', [
                'title' => 'Edit User',
                'user' => $user,
                'errors' => $errors
            ]);
        }

        // Update user
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $user->is_active = isset($data['is_active']) && $data['is_active'] === '1';

        if (isset($data['email_verified']) && $data['email_verified'] === '1' && !$user->email_verified_at) {
            $user->email_verified_at = now();
        } elseif ((!isset($data['email_verified']) || $data['email_verified'] !== '1') && $user->email_verified_at) {
            $user->email_verified_at = null;
        }

        $user->updated_at = now();
        $user->save();

        return $response
            ->withHeader('Location', '/mark/users')
            ->withStatus(302);
    }

    /**
     * Delete the specified user
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $user = User::find($args['id']);

        if ($user) {
            $user->delete();
        }

        return $response
            ->withHeader('Location', '/mark/users')
            ->withStatus(302);
    }

    /**
     * Validate user data
     *
     * @param array $data
     * @param int|null $userId
     * @return array
     */
    private function validateUser(array $data, ?int $userId = null): array
    {
        $errors = [];

        // Validate name
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }

        // Validate email
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email is invalid';
        } else {
            // Check if email is unique
            $query = User::where('email', $data['email']);

            if ($userId) {
                $query->where('id', '!=', $userId);
            }

            if ($query->exists()) {
                $errors['email'] = 'Email is already taken';
            }
        }

        // Validate password
        if (!$userId && empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (!empty($data['password']) && strlen($data['password']) < 8) {
            $errors['password'] = 'Password must be at least 8 characters';
        }

        return $errors;
    }
}
