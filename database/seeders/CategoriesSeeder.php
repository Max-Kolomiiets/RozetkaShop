<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public $categories_cnt = 10;
    public $attributes_cnt = [5, 15];

    private function fakeSeed()
    {
        $categories = Category::factory()->count($this->categories_cnt)->create()->all();
        foreach ($categories as $category) {
            for ($i=0; $i < rand($this->attributes_cnt[0], $this->attributes_cnt[1]); $i++) { 
                CategoryAttribute::factory()->create(['category_id'=>$category->id]);
            }
        }
    }
    public function run()
    {
        $json_data = File::get("database\seeders\categories.json");
        $categories = json_decode($json_data);
        foreach ($categories as $category) {
            $category_data = [
                'name' => $category->name,
                'alias'=> $category->alias
            ];
            $category_id = Category::factory()->create($category_data)->id;
            foreach ($category->attributes as $attribute) {
                $attributes_data = [
                    "name"=> $attribute->name,
                    "alias"=> $attribute->alias,
                    "filter"=> $attribute->filtered,
                    "required"=> $attribute->required
                ];
                $attribute_id = Attribute::factory()->create($attributes_data)->id;
                CategoryAttribute::factory()->create([
                    'category_id'=>$category_id,
                    'attribute_id'=>$attribute_id
                ]);
            }
        }
    }
}
