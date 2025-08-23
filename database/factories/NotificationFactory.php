<?php
namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        $user = User::where(function ($q) {
            $q->whereJsonContains('user_roles', 'admin')
                ->orWhereJsonContains('user_roles', 'agent')
                ->orWhereJsonContains('user_roles', 'member');
        })
            ->inRandomOrder()
            ->first();

        return [
            'user_id' => $user->id,
            'title'   => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'type'    => $this->faker->randomElement(['payment', 'membership', 'review', 'chat', 'property', 'project', 'profile']),
            'is_read' => $this->faker->boolean(),
        ];
    }
}
