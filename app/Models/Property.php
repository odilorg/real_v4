<?php

namespace App\Models;

use App\Enums\FurnishingLevel;
use App\Enums\HeatingType;
use App\Enums\ParkingType;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Property extends Model
{
    use SoftDeletes, HasSlug;

    protected $fillable = [
        'owner_id','title','slug','description',
        'property_type','status','ownership_type','year_built',
        'area_total','area_living','bedrooms','bathrooms','floors','floor_no',
        'parking','heating','furnishing','orientation','energy_class','utilities',
        'lat','lng','country','state','city','district','street','house_no','postal_code',
        'published_at',
        // geolocation & map_bbox are handled by DB; we won't mass-assign them directly
    ];

    protected $casts = [
        'property_type' => PropertyType::class,
        'status'        => PropertyStatus::class,
        'parking'       => ParkingType::class,
        'heating'       => HeatingType::class,
        'furnishing'    => FurnishingLevel::class,
        'utilities'     => 'array',
        'published_at'  => 'datetime',
        'lat'           => 'decimal:7',
        'lng'           => 'decimal:7',
        'bathrooms'     => 'decimal:1',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

    /** Relationships */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function taxonomies(): BelongsToMany
    {
        return $this->belongsToMany(Taxonomy::class, 'property_taxonomy');
    }

    /** Scopes */
    public function scopePublished($q)
    {
        return $q->where('status', PropertyStatus::PUBLISHED);
    }

    public function scopeCity($q, ?string $city)
    {
        return $city ? $q->where('city', $city) : $q;
    }
}
