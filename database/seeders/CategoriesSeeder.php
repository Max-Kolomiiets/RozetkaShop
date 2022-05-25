<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public $categories_cnt = 10;
    public $attributes_cnt = [5, 15];

    public function run()
    {
        $categories = Category::factory()->count($this->categories_cnt)->create()->all();
        foreach ($categories as $category) {
            for ($i=0; $i < rand($this->attributes_cnt[0], $this->attributes_cnt[1]); $i++) { 
                CategoryAttribute::factory()->create(['category_id'=>$category->id]);
            }
        }
    }
}
