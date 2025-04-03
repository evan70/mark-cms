<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MarkUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'email_verified_at',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /**
     * Check if the user is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if the user has verified their email
     *
     * @return bool
     */
    public function hasVerifiedEmail(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * Mark the user's email as verified
     *
     * @return bool
     */
    public function markEmailAsVerified(): bool
    {
        return $this->update([
            'email_verified_at' => now()
        ]);
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is an editor
     *
     * @return bool
     */
    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    /**
     * Check if the user is a contributor
     *
     * @return bool
     */
    public function isContributor(): bool
    {
        return $this->role === 'contributor';
    }

    /**
     * Check if the user has access to the admin area
     *
     * @return bool
     */
    public function hasAdminAccess(): bool
    {
        return $this->isActive() && ($this->isAdmin() || $this->isEditor());
    }
}
