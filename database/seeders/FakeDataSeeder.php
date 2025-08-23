<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Subscription, Payment, PropertyAd, ProjectAd, Image, Review, ChatMessage, Notification};

class FakeDataSeeder extends Seeder
{
    public function run(): void
    {
        Subscription::factory(5)->create();
        Payment::factory(5)->create();
        PropertyAd::factory(5)->create();
        ProjectAd::factory(5)->create();
        Image::factory(5)->create();
        Review::factory(5)->create();
        ChatMessage::factory(5)->create();
        Notification::factory(5)->create();
    }
}
