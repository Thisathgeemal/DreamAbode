<?php
namespace Database\Factories;

use App\Models\Image;
use App\Models\ProjectAd;
use App\Models\PropertyAd;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'property_id' => PropertyAd::inRandomOrder()->first()->property_id ?? PropertyAd::factory(),
            'project_id'  => ProjectAd::inRandomOrder()->first()->project_id ?? ProjectAd::factory(),
            'image_path'  => $this->faker->imageUrl(800, 600, 'real-estate', true),
        ];
    }
}
