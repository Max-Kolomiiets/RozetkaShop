<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\LogisticParameters;

class LogisticParametersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LogisticParameters::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $numb = [
            rand(100, 8000), 
            rand(100, 8000),
            rand(100, 2000),
            rand(100, 8000)
        ];
        return [
            'packing_weight' => $numb[0], 
            'packing_height' => $numb[1], 
            'packing_width' => $numb[2], 
            'packing_depth' => $numb[3], 
            'packages_quantity' => 1
        ];
    }
}
