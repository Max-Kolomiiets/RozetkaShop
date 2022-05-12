<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Guaranty;
use App\Models\Vendor;
use App\Models\Product;

class GuarantyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guaranty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $term = [12, 24, 36];
        return [
            'term' => $term[rand(0, 2)],
            'description' => $this->faker->text(2000),
            'url' => $this->faker->url(),
            'vendor_id' => Vendor::factory(),
            'product_id' => Product::factory()
        ];
    }
}
