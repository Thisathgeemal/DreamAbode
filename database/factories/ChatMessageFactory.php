<?php
namespace Database\Factories;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatMessageFactory extends Factory
{
    protected $model = ChatMessage::class;

    public function definition(): array
    {

        $users = User::where(function ($q) {
            $q->whereJsonContains('user_roles', 'admin')
                ->orWhereJsonContains('user_roles', 'agent')
                ->orWhereJsonContains('user_roles', 'member');
        })->get();

        $sender   = $users->random();
        $receiver = $users->where('id', '!=', $sender->id)->random();

        return [
            'sender_id'   => $sender->id,
            'receiver_id' => $receiver->id,
            'message'     => $this->faker->sentence(),
            'is_read'     => $this->faker->boolean(),
        ];
    }
}
