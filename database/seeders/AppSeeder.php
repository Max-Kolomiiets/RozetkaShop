<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryAttribut;
use App\Models\Price;
use App\Models\Availability;
use App\Models\Image;
use App\Models\Description;
use App\Models\Guaranty;
use App\Models\Characteristic;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $countries_cnt = 5;
    public $vendors_cnt = 9;
    public $categories_cnt = 10; 
    public $attributes_cnt = 2;
    public $products_cnt = 30;
    public $characteristic_in_product_cnt = 6;
    public $images_cnt = 16;
    public $attributes_in_category_cnt = 10;

    public $Countries;
    public $Vendors;
    public $Categories;

    public $CategoryAttributes = [];


    public function run()
    {
        $this->Countries = Country::factory()->count($this->countries_cnt)->create();

        $this->Vendors = Vendor::factory()->count($this->vendors_cnt)->create(['country_id'=> $this->Countries->all()[rand(0, $this->countries_cnt - 1)]->id]);

        $this->Categories = Category::factory()->count($this->categories_cnt)->create();

        $this->Categories->each(function($c){
            $this->CategoryAttributes[$c->id] = CategoryAttribut::factory()->count($this->attributes_in_category_cnt)->create(['category_id'=>$c->id]);
        });

        $Products = Product::factory()->count($this->products_cnt)->create([
            'vendor_id'=>$this->Vendors->all()[rand(0, $this->vendors_cnt - 1)]->id, 
            'category_id'=>$this->Categories->all()[rand(0, $this->categories_cnt - 1)]->id
        ]);

        $Products->each(function($p){
            Price::factory()->create(['product_id'=>$p->id]);

            Availability::factory()->create(['product_id'=>$p->id]);

            Image::factory()->count($this->images_cnt)->create(['product_id'=>$p->id]);

            Description::factory()->create(['product_id'=>$p->id, 'country_id'=> $this->Countries->all()[rand(0, $this->countries_cnt - 1)]->id]);

            Guaranty::factory()->create(['product_id'=>$p->id, 'product_id'=>$p->vendor_id]);
            Characteristic::factory()
            ->count($this->characteristic_in_product_cnt)
            ->create([
                'product_id'=>$p->id, 
                'attribute_id'=>$this ->CategoryAttributes[$p->category_id]
                    ->all()[rand(0, $this->CategoryAttributes[$p->category_id]->count() - 1)]
                    ->attribut_id
            ]);
        });
    }
}
