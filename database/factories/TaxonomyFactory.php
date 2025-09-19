<?php

namespace Database\Factories;

use App\Models\Taxonomy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaxonomyFactory extends Factory
{
    protected $model = Taxonomy::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['property_type','category','tag','city']);
        $name = match ($type) {
            'property_type' => $this->faker->randomElement(['Apartment','House','Land','Commercial','Room Share']),
            'category'      => $this->faker->randomElement(['New Build','Luxury','Affordable','Investment']),
            'tag'           => ucfirst($this->faker->word()),
            'city'          => $this->faker->city(),
            default         => ucfirst($this->faker->word()),
        };

        return [
            'type' => $type,
            'name' => $name,
            'slug' => Str::slug($name.'-'.Str::random(4)),
            'parent_id' => null,
            'order_column' => 0,
            'meta' => [],
        ];
    }
}
