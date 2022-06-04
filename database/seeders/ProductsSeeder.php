<?php

namespace Database\Seeders;

use App\Models\Attribute;
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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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

    private function fakeSeed(){
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

    private function getCategory($category)
    {
        return Category::firstWhere('name', $category)->id;
    }
    private function getVendor($vendor)
    {
        return Vendor::firstWhere('name', $vendor)->id;
    }
    private function getCountry($country)
    {
        return Country::firstWhere("name", $country)->id;
    }
    private function getAttribute($attribute)
    {
        return Attribute::firstWhere("name", $attribute)->id;
    }
    public function getImages($folderName)
    {
        $fullPath = "public\\images\\".$folderName;
        $pathes = Storage::files($fullPath);
        $images_pathes = [];
        foreach ($pathes as $path) {
            $new_path = substr_replace($path, "", 0, 7);
            array_push($images_pathes, $new_path);
        }
        return $images_pathes;
    }

    public function run()
    {
        $json_data = File::get("database\seeders\products.json");
        $products = json_decode($json_data);
        foreach ($products as $product) {
            $product_data = [
                'name' =>$product->name,
                'alias' =>$product->article,
                'category_id'=>$this->getCategory($product->category),
                'vendor_id'=>$this->getVendor($product->vendor),
            ];
            $product_id = Product::factory()->create($product_data)->id;
            $price_data = [
                'product_id'=>$product_id,
                'price'=>$product->price * 100
            ];
            Price::factory()->create($price_data);

            $availability_data = [
                'product_id'=>$product_id,
                'quantity'=>$product->quantity
            ];
            Availability::factory()->create($availability_data);

            $description_data = [
                'product_id'=>$product_id,
                'state'=>$product->state,
                'ean'=>$product->ean,
                'description'=>$product->description,
                'country_id' => $this->getCountry($product->country)
            ];
            Description::factory()->create($description_data);

            $guaranty_data = [
                'product_id' => $product_id,
                'term' => $product->guaranty->term,
                'vendor_id' => $product_data['vendor_id']
            ];
            Guaranty::factory()->create($guaranty_data);

            foreach ($product->attributes as $attribute) {
                $characteristic_data = [
                    'product_id'=>$product_id,
                    'attribute_id'=> $this->getAttribute($attribute->name),
                    'value'=>$attribute->value
                ];
                Characteristic::factory()->create($characteristic_data);
            }
            
            $pathes = $this->getImages($product->images_directory);
            foreach ($pathes as $path) {
                $image = [
                    'product_id' => $product_id,
                    'url' => $path
                ];
                Image::factory()->create($image);
            }
        }
    }
}
