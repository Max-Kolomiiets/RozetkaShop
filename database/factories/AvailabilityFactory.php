<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Availability;
use App\Models\Product;

class AvailabilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Availability::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hiden'=>[true, false][rand(0,1)],
            'availability'=>[true, false][rand(0,1)],
            'quantity'=> rand(10, 200),
            'product_id' => Product::factory()
        ];
    }
}
