<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;
use App\Models\Product;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'alias' => $this->faker->word(),
            'url' => $this->faker->imageUrl($width = 640, $height = 480),
            'alt' => $this->faker->sentence(),
            'title' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTime('now', null),
            'product_id' => Product::factory()
        ];
    }
}
