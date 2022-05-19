<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Characteristic;
use App\Models\Country;
use App\Models\Description;
use App\Models\Guaranty;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Descriptor\Descriptor;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $products_cnt = 150;
    public $images_cnt = [3, 16];
    public function run()
    {
        $categories = Category::all();
        $vendors = Vendor::all();
        $countires = Country::all();
        for ($i=0; $i < $this->products_cnt; $i++) { 
            $category_id = $categories[rand(0, count($categories) - 1)]->id;
            $vendor_id = $vendors[rand(0, count($vendors) - 1)]->id;
            $countiry_id = $countires[rand(0, count($countires) - 1)]->id;

            $product = Product::factory()->create([
                'vendor_id'=> $vendor_id, 
                'category_id'=>$category_id
            ]);
            Price::factory()->create(['product_id'=>$product->id]);
            Availability::factory()->create(['product_id'=>$product->id]);
            Image::factory()->count(rand($this->images_cnt[0], $this->images_cnt[1]))->create(['product_id'=>$product->id]);
            Description::factory()->create(['product_id'=>$product->id, 'country_id'=>$countiry_id]);
            Guaranty::factory()->create(['product_id'=>$product->id, 'vendor_id'=> $vendor_id]);

            $category_attributes = CategoryAttribute::where('category_id', $category_id)->get();
            foreach ($category_attributes as $attr) {
                if(rand(0, 6))
                {
                    Characteristic::factory()->create([
                        'product_id'=>$product->id,
                        'attribute_id'=>$attr->id
                    ]);
                }
            }

        }
    }
}
