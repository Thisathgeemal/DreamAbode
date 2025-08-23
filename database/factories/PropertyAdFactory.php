<?php
namespace Database\Factories;

use App\Models\PropertyAd;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyAdFactory extends Factory
{
    protected $model = PropertyAd::class;

    public function definition(): array
    {
        return [
            'agent_id'      => User::whereJsonContains('user_roles', 'agent')
                ->inRandomOrder()
                ->value('id'),
            'admin_id'      => User::whereJsonContains('user_roles', 'admin')
                ->inRandomOrder()
                ->value('id'),
            'member_id'     => User::whereJsonContains('user_roles', 'member')
                ->inRandomOrder()
                ->value('id'),
            'property_name' => $this->faker->streetName(),
            'property_type' => $this->faker->randomElement(['house', 'apartment', 'land', 'bungalow', 'villa', 'commercial']),
            'location'      => $this->faker->city(),
            'measurement'   => $this->faker->numberBetween(500, 5000),
            'perches'       => $this->faker->numberBetween(5, 50),
            'bedrooms'      => $this->faker->numberBetween(1, 6),
            'bathrooms'     => $this->faker->numberBetween(1, 4),
            'floors'        => $this->faker->numberBetween(0, 3),
            'price'         => $this->faker->numberBetween(1000000, 100000000),
            'post_type'     => $this->faker->randomElement(['sale', 'rent']),
            'status'        => $this->faker->randomElement(['active', 'sold', 'rented']),
        ];
    }
}
