<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attribute;

class AttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->word();
        $value_types = ['text', 'number', 'txt_array', 'num_array'];
        return [
            'name' => $name,
            'alias' => ucfirst($name),
            'value_type' => $value_types[rand(0, 3)],
            'filter' => [true, false][rand(0,1)],
            'required'=> [true, false][rand(0,1)]
        ];
    }
}
