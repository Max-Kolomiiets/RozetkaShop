<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CategoryAttribut;
use App\Models\Category;
use App\Models\Attribute;

class CategoryAttributFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryAttribut::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id'=>Category::factory(), 
            'attribut_id'=>Attribute::factory()
        ];
    }
}
