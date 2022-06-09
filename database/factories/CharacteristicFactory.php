<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Characteristic;
use App\Models\Attribute;
use App\Models\Product;

class CharacteristicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Characteristic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $value = 0;
        if (rand(0,1)) {
            $value = rand(0, 10);
        }
        else {
            $value = $this->faker->word();
        }
        return [
            'value'=>$value, 
            'alias'=>Str::slug(strtolower($value), "_"),
            'attribute_id'=>Attribute::factory(),
            'product_id'=>Product::factory()
        ];
    }
}
