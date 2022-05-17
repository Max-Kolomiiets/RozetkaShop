<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Description;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Availability;
use App\Models\Category;
use App\Models\CategoryAttribut;
use App\Models\Characteristic;
use Database\Factories\CategoryFactory;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $category_id = 3;
        $selected_products = Product::where("category_id", $category_id)->get();
        $products = [];
        foreach ($selected_products as $it) {
            array_push($products, (object)[
                'name'=> $it->name,
                'image_url'=> Image::firstWhere("product_id", $it->id)->url,
                'price' => Price::firstWhere("product_id", $it->id)->price / 100.0,
                'description' => Description::firstWhere("product_id", $it->id)->description
            ]);
        }
        $category_name = Category::find($category_id)->name;

        $selected_attributes = CategoryAttribut::where("category_Id", $category_id)->get();
        $attributes = [];
        foreach ($selected_attributes as $it) {
            $selected_values = Characteristic::where("attribute_id", $it->id)->get();
            $values = [];
            foreach ($selected_values as $value) {
                array_push($values, $value->value);
            }
            array_push($attributes, (object)[
                'name'=>Attribute::find($it->attribut_id)->name,
                'values'=>$values,
            ]);
        }
        return view("products", compact("category_name", "products", "attributes"));
    }

    public function product()
    {
        $product_id = 4;
        $product = Product::find($product_id);
        $images = Image::Where("product_id", $product_id)->limit(5)->get()->toArray();
        $image = (object)array_shift($images);
        $price = Price::firstWhere("product_id", $product_id)->price / 100.0;
        $availabulity = Availability::firstWhere("product_id", $product_id);
        $description = Description::firstWhere("product_id", $product_id)->description;
        $product_info = (object)[
            'name'=>$product->name,
            'main_image'=>$image,
            'images'=> $images,
            'price'=>$price,
            'description'=>substr($description, 0, 200)
        ];
        return view("product", compact("product_info"));
    }
}
