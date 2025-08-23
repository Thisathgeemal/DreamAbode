<?php
namespace Database\Factories;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 month', 'now');
        $end   = (clone $start)->modify('+30 days');

        return [
            'member_id'  => User::whereJsonContains('user_roles', 'member')
                ->inRandomOrder()
                ->value('id'),
            'type_id'    => SubscriptionType::inRandomOrder()
                ->value('type_id'),
            'start_date' => $start,
            'end_date'   => $end,
            'status'     => $this->faker->randomElement(['pending', 'active', 'expired', 'canceled']),
            'payment_id' => Payment::factory(),
        ];
    }
}
