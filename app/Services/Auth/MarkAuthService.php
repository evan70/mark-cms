<?php

namespace App\Services\Auth;

use App\Models\MarkUser;
use Psr\Http\Message\ServerRequestInterface as Request;
use Carbon\Carbon;

class MarkAuthService
{
    /**
     * Attempt to authenticate a mark user
     *
     * @param string $email
     * @param string $password
     * @return MarkUser|null
     */
    public function attempt(string $email, string $password): ?MarkUser
    {
        $user = MarkUser::where('email', $email)
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
     * Log in a mark user
     *
     * @param Request $request
     * @param MarkUser $user
     * @return void
     */
    public function login(Request $request, MarkUser $user): void
    {
        $_SESSION['mark_user_id'] = $user->id;
        $_SESSION['mark_user_last_activity'] = time();
    }

    /**
     * Log out the current mark user
     *
     * @return void
     */
    public function logout(): void
    {
        if (isset($_SESSION['mark_user_id'])) {
            unset($_SESSION['mark_user_id']);
            unset($_SESSION['mark_user_last_activity']);
        }
    }

    /**
     * Get the current authenticated mark user
     *
     * @return MarkUser|null
     */
    public function user(): ?MarkUser
    {
        if (!isset($_SESSION['mark_user_id'])) {
            return null;
        }

        return MarkUser::find($_SESSION['mark_user_id']);
    }

    /**
     * Check if a mark user is authenticated
     *
     * @return bool
     */
    public function check(): bool
    {
        return isset($_SESSION['mark_user_id']);
    }

    /**
     * Check if a mark user is a guest
     *
     * @return bool
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    /**
     * Check if the authenticated user has admin access
     *
     * @return bool
     */
    public function hasAdminAccess(): bool
    {
        $user = $this->user();

        if (!$user) {
            return false;
        }

        return $user->hasAdminAccess();
    }
}
