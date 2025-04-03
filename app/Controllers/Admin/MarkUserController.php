<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MarkUser;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MarkUserController extends BaseController
{
    /**
     * Display a listing of mark users
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $users = MarkUser::orderBy('created_at', 'desc')->get();

        return $this->render($response, $request, 'mark.mark_users.index', [
            'title' => 'Mark Users',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new mark user
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        return $this->render($response, $request, 'mark.mark_users.create', [
            'title' => 'Create Mark User'
        ]);
    }

    /**
     * Store a newly created mark user
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
            return $this->render($response, $request, 'mark.mark_users.create', [
                'title' => 'Create Mark User',
                'errors' => $errors,
                'data' => $data
            ]);
        }

        // Create mark user
        MarkUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'role' => $data['role'] ?? 'contributor',
            'is_active' => isset($data['is_active']) && $data['is_active'] === '1',
            'email_verified_at' => isset($data['email_verified']) && $data['email_verified'] === '1' ? now() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $response
            ->withHeader('Location', '/mark/mark-users')
            ->withStatus(302);
    }

    /**
     * Show the form for editing the specified mark user
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function edit(Request $request, Response $response, array $args): Response
    {
        $user = MarkUser::find($args['id']);

        if (!$user) {
            return $response->withStatus(404);
        }

        return $this->render($response, $request, 'mark.mark_users.edit', [
            'title' => 'Edit Mark User',
            'user' => $user
        ]);
    }

    /**
     * Update the specified mark user
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        $user = MarkUser::find($args['id']);

        if (!$user) {
            return $response->withStatus(404);
        }

        $data = $request->getParsedBody();

        // Validate data
        $errors = $this->validateUser($data, $user->id);

        if (!empty($errors)) {
            return $this->render($response, $request, 'mark.mark_users.edit', [
                'title' => 'Edit Mark User',
                'user' => $user,
                'errors' => $errors
            ]);
        }

        // Update mark user
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'] ?? 'contributor';

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
            ->withHeader('Location', '/mark/mark-users')
            ->withStatus(302);
    }

    /**
     * Delete the specified mark user
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $user = MarkUser::find($args['id']);

        if ($user) {
            $user->delete();
        }

        return $response
            ->withHeader('Location', '/mark/mark-users')
            ->withStatus(302);
    }

    /**
     * Validate mark user data
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
            $query = MarkUser::where('email', $data['email']);

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

        // Validate role
        if (empty($data['role'])) {
            $errors['role'] = 'Role is required';
        } elseif (!in_array($data['role'], ['admin', 'editor', 'contributor'])) {
            $errors['role'] = 'Invalid role';
        }

        return $errors;
    }
}
