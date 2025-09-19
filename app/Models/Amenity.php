<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Amenity extends Model
{
    use SoftDeletes, HasSlug;

    protected $fillable = [
        'name', 'slug', 'category', 'icon', 'order_column', 'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    /** Query scopes */
    public function scopeCategory($query, ?string $category)
    {
        return $category ? $query->where('category', $category) : $query;
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_column')->orderBy('name');
    }
}
