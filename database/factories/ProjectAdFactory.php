<?php
namespace Database\Factories;

use App\Models\ProjectAd;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectAdFactory extends Factory
{
    protected $model = ProjectAd::class;

    public function definition(): array
    {
        return [
            'agent_id'        => User::whereJsonContains('user_roles', 'agent')
                ->inRandomOrder()
                ->value('id'),
            'admin_id'        => User::whereJsonContains('user_roles', 'admin')
                ->inRandomOrder()
                ->value('id'),
            'buyer_id'        => User::whereJsonContains('user_roles', 'member')
                ->inRandomOrder()
                ->value('id'),
            'member_id'       => User::whereJsonContains('user_roles', 'member')
                ->inRandomOrder()
                ->value('id'),
            'project_name'    => $this->faker->company(),
            'property_type'   => $this->faker->randomElement(['apartment', 'commercial']),
            'location'        => $this->faker->city(),
            'total_units'     => $this->faker->numberBetween(10, 200),
            'measurement'     => $this->faker->numberBetween(500, 5000),
            'price'           => $this->faker->numberBetween(5000000, 200000000),
            'status'          => $this->faker->randomElement(['ongoing', 'completed', 'upcoming']),
            'completion_date' => $this->faker->date(),
        ];
    }
}
