<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'body',
        'cover_image',
        'author_name',
        'author_initials',
        'author_role',
        'author_bio',
        'tags',
        'read_minutes',
        'is_featured',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Les articles sont accessibles par leur slug dans l'URL.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Limiter aux articles publiés (date de publication passée).
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Date de publication formatée en français : « 24 mai 2026 ».
     */
    public function getPublishedDateAttribute(): ?string
    {
        return $this->published_at?->locale('fr')->isoFormat('D MMMM YYYY');
    }

    /**
     * Métadonnée prête à l'emploi : « 24 mai 2026 · 6 min de lecture ».
     */
    public function getMetaLineAttribute(): string
    {
        return trim(($this->published_date ?? '').' · '.$this->read_minutes.' min de lecture', ' ·');
    }
}
