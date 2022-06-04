<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Description;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use Database\Seeders\ProductsSeeder;
use Illuminate\Http\Request;
use Symfony\Component\Console\Descriptor\Descriptor;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $seeder = new ProductsSeeder();
        $categories = [];
        foreach (Category::all() as $category) {
            if(count(Product::where("category_id", $category->id)->get()) > 0)
            {
                array_push($categories, $category);
            }
        }
        
        $products = Product::paginate(25);

        return view("home", compact("categories", "products"));
    }

    // public function search(Request $request)
    // {
    //     $text = $request->text;
    //     $products = Product::cursor()->filter(function($product) use($text){
    //         $metaphone_check = (levenshtein(metaphone($text), metaphone($product->name)) < mb_strlen(metaphone($text))/2); 
    //         $check = (levenshtein($text, $product->name) < mb_strlen($text)/2);
    //         $substring = strripos(' '.$product->name, (string)$text);
    //         $substring = [false, $substring <= strlen($text)][$substring != false];
    //         return $substring || $metaphone_check && $check;
    //     }); 
    //     return response()->json(["saccess"=>$products]);
    // }
}