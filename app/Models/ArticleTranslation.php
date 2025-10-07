<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleTranslation extends Model
{
    protected $fillable = [
        'article_id',
        'locale',
        'slug',
        'title',
        'perex',
        'content',
        'meta_title',
        'meta_description'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
