<?php

namespace Database\Factories;

use App\Models\Amenity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AmenityFactory extends Factory
{
    protected $model = Amenity::class;

    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'Air Conditioning','Heating','Balcony','Garden','Garage','Security System',
            'Elevator','Wheelchair Access','Swimming Pool','Fireplace','High-Speed Internet'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.Str::random(4)),
            'category' => $this->faker->randomElement(['Interior','Exterior','Safety','Accessibility','Technology']),
            'icon' => null,
            'order_column' => 0,
            'meta' => [],
        ];
    }
}
