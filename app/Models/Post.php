<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category',
        'cover_image',
        'excerpt',
        'content',
        'published_at',
        'is_featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    protected $appends = [
        'cover_image_url',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCoverImageUrlAttribute(): string
    {
        $path = $this->cover_image;

        if (! $path) {
            return 'https://via.placeholder.com/1200x675?text=Multiverse+Comics';
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return '/' . ltrim($path, '/');
    }
}
