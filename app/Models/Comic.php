<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Comic extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'universe',
        'series',
        'writer',
        'artist',
        'description',
        'price',
        'stock',
        'release_date',
        'cover_image',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'release_date' => 'date',
        'is_featured' => 'boolean',
    ];

    protected $appends = [
        'cover_image_url',
    ];

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format((float) $this->price, 2);
    }

    public function getCoverImageUrlAttribute(): string
    {
        $path = $this->cover_image;

        if (! $path) {
            return 'https://via.placeholder.com/600x900?text=Multiverse+Comics';
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return '/' . ltrim($path, '/');
    }
}
