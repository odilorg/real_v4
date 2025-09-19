<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'logo', 'description', 'contacts', 'billing', 'users_count',
    ];

    protected $casts = [
        'contacts' => 'array',
        'billing'  => 'array',
    ];

    

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    protected static function booted()
    {
        static::saved(function (self $agency) {
            // Keep users_count in sync (cheap approach; for heavy scale use events/queued job)
            $agency->users_count = $agency->users()->count();
            $agency->saveQuietly();
        });
    }
}
