<?php
namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'member_id'   => User::whereJsonContains('user_roles', 'member')
                ->orWhereJsonContains('user_roles', 'agent')
                ->inRandomOrder()
                ->value('id'),

            'rating'      => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->paragraph(),
        ];
    }
}
