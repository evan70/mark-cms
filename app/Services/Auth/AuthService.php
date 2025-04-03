<?php

namespace App\Services\Auth;

use App\Models\User;
use Psr\Http\Message\ServerRequestInterface as Request;
use Carbon\Carbon;

class AuthService
{
    /**
     * Attempt to authenticate a user
     *
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function attempt(string $email, string $password): ?User
    {
        $user = User::where('email', $email)
            ->where('is_active', true)
            ->first();

        if ($user && password_verify($password, $user->password)) {
            // Update last login
            $user->update(['last_login_at' => Carbon::now()]);
            return $user;
        }

        return null;
    }

    /**
     * Log in a user
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function login(Request $request, User $user): void
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_last_activity'] = time();
    }

    /**
     * Log out the current user
     *
     * @return void
     */
    public function logout(): void
    {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_last_activity']);
        }
    }

    /**
     * Get the current authenticated user
     *
     * @return User|null
     */
    public function user(): ?User
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return User::find($_SESSION['user_id']);
    }

    /**
     * Check if a user is authenticated
     *
     * @return bool
     */
    public function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Check if a user is a guest
     *
     * @return bool
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    /**
     * Register a new user
     *
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        // Hash the password
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        // Create the user
        return User::create($data);
    }
}
