<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Description;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\Console\Descriptor\Descriptor;

class HomeController extends Controller
{
    public function index()
    {
        $categories = [];
        foreach (Category::all() as $category) {
            if(count(Product::where("category_id", $category->id)->get()) > 0)
            {
                array_push($categories, $category);
            }
        }
        
        $selected_products = Product::all();
        $products = [];
        foreach ($selected_products as $it) {
            array_push($products, (object)[
                'id'=>$it->id,
                'name'=> $it->name,
                'image_url'=> Image::firstWhere("product_id", $it->id)->url,
                'price' => Price::firstWhere("product_id", $it->id)->price / 100.0,
                'description' => Description::firstWhere("product_id", $it->id)->description
            ]);
        }
        return view("home", compact("categories", "products"));
    }

    public function search(Request $request)
    {
        $text = $request->text;
        $products = Product::cursor()->filter(function($product) use($text){
            $metaphone_check = (levenshtein(metaphone($text), metaphone($product->name)) < mb_strlen(metaphone($text))/2); 
            $check = (levenshtein($text, $product->name) < mb_strlen($text)/2);
            $substring = strripos(' '.$product->name, (string)$text);
            $substring = [false, $substring <= strlen($text)][$substring != false];
            return $substring || $metaphone_check && $check;
        }); 
        return response()->json(["saccess"=>$products]);
    }
}