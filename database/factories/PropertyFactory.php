<?php

namespace Database\Factories;

use App\Enums\FurnishingLevel;
use App\Enums\HeatingType;
use App\Enums\ParkingType;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $title = $this->faker->streetAddress().' '.$this->faker->city().' Home';

        $lat = $this->faker->randomFloat(7, 37.0, 46.0); // roughly Central Asia
        $lng = $this->faker->randomFloat(7, 55.0, 72.0);

        return [
            'owner_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'title' => $title,
            'slug' => Str::slug($title.'-'.Str::random(5)),
            'description' => $this->faker->paragraphs(2, true),
            'property_type' => $this->faker->randomElement(PropertyType::cases())->value,
            'status' => $this->faker->randomElement([PropertyStatus::DRAFT, PropertyStatus::PUBLISHED])->value,
            'ownership_type' => $this->faker->randomElement(['freehold','leasehold','other']),
            'year_built' => $this->faker->numberBetween(1960, 2024),
            'area_total' => $this->faker->randomFloat(2, 35, 350),
            'area_living' => $this->faker->randomFloat(2, 20, 250),
            'bedrooms' => $this->faker->numberBetween(1, 6),
            'bathrooms' => $this->faker->randomElement([1.0,1.5,2.0,2.5,3.0]),
            'floors' => $this->faker->numberBetween(1, 3),
            'floor_no' => $this->faker->numberBetween(0, 20),
            'parking' => $this->faker->randomElement(ParkingType::cases())->value,
            'heating' => $this->faker->randomElement(HeatingType::cases())->value,
            'furnishing' => $this->faker->randomElement(FurnishingLevel::cases())->value,
            'orientation' => $this->faker->randomElement(['N','S','E','W','NE','NW','SE','SW']),
            'energy_class' => $this->faker->randomElement(['A','B','C','D','E']),
            'utilities' => ['water' => true, 'gas' => true, 'electricity' => true, 'internet' => $this->faker->boolean()],
            'lat' => $lat,
            'lng' => $lng,
            'country' => 'Uzbekistan',
            'state' => null,
            'city' => $this->faker->randomElement(['Tashkent','Samarkand','Bukhara','Khiva','Fergana']),
            'district' => $this->faker->word(),
            'street' => $this->faker->streetName(),
            'house_no' => (string)$this->faker->buildingNumber(),
            'postal_code' => $this->faker->postcode(),
            'published_at' => now()->subDays(rand(0, 60)),
        ];
    }
}
