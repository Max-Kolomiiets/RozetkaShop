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
    public function getProductCharacteristics($characteristic)
    {
        $attribute = Attribute::find($characteristic->attribute_id);
        return (object)[
            'name' => $attribute->name,
            'value'=> $characteristic->value
        ];
    }
    public function show($id)
    {
        $product_id = $id;
        $product = Product::find($product_id);
        $images = Image::Where("product_id", $product_id)->limit(5)->get()->toArray();
        $image = (object)array_shift($images);
        $price = Price::firstWhere("product_id", $product_id)->price / 100.0;
        $availabulity = Availability::firstWhere("product_id", $product_id);
        $description = Description::firstWhere("product_id", $product_id)->description;

        $selected_characteristics = Characteristic::where("product_id", $product_id)->get();
        $characteristics = [];
        foreach ($selected_characteristics as $scharacteristic) {
            array_push($characteristics, $this->getProductCharacteristics( $scharacteristic));
        }
        $product_info = (object)[
            'id'=>$product->id,
            'name'=>$product->name,
            'main_image'=>$image,
            'images'=> $images,
            'price'=>$price,
            'description'=>substr($description, 0, 200),
            'characteristics'=>$characteristics
        ];
        return view("product", compact("product_info"));
    }
}
