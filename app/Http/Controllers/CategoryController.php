<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Description;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use App\Models\CategoryAttribut;
use App\Models\Characteristic;
use App\Models\Attribute;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category_id = 1;
    }
    
    public function show($id)
    {
        $category_id = $id;
        $selected_products = Product::where("category_id", $category_id)->get();

        if(count($selected_products) == 0) return redirect(route("main.index"));

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
                $finded_products_cnt = count(array_filter($selected_products->toArray(), function($e) use ($value){
                    return $e['id'] == $value->product_id;
                }));
                if($finded_products_cnt > 0)
                {
                    array_push($values, $value->value);
                }
            }
            array_push($attributes, (object)[
                'name'=>Attribute::find($it->attribut_id)->name,
                'values'=>$values,
            ]);
        }
        return view("products", compact("category_name", "products", "attributes"));
    }
}
