<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Category;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(rand(0,3), true);
        return [
            'name' => ucwords($name),
            'alias' => str_replace(' ', '_', $name),
            'vendor_id'  => Vendor::factory(),
            'category_id' => Category::factory()
        ];
    }
}
