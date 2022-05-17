<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Price;
use App\Models\Product;

class PriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Price::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $price = rand(50, 1000000);
        $old_cof = rand(10, 90) / 100;
        $promo_cof = rand(10, 90) / 100;
        return [
            'price' => $price, 
            'price_old' => [0, (int)round($price * $old_cof)][(int)rand(0, 7) == 0], 
            'price_promo' => [0, (int)round($price * $promo_cof)][(int)rand(0, 7) == 0],
            'product_id' => Product::factory()
        ];
    }
}
