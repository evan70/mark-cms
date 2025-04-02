<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'slug'
    ];

    /**
     * Get all translations for the tag
     */
    public function translations(): HasMany
    {
        return $this->hasMany(TagTranslation::class);
    }

    /**
     * Get all articles with this tag
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_tags');
    }

    /**
     * Get translation for specific locale
     */
    public function getTranslation(string $locale): ?TagTranslation
    {
        $translation = $this->translations()->where('locale', $locale)->first();
        return $translation instanceof TagTranslation ? $translation : null;
    }

    /**
     * Delete tag with all translations
     */
    public function delete(): ?bool
    {
        $this->translations()->delete();
        return parent::delete();
    }
}
