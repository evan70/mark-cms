<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagTranslation extends Model
{
    protected $fillable = [
        'tag_id',
        'locale',
        'name'
    ];

    /**
     * Get the tag that owns the translation
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * Validation rules for the model
     */
    public static function rules(): array
    {
        return [
            'name' => 'required|string|max:255'
        ];
    }
}