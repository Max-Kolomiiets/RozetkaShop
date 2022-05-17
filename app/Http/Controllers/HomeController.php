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
        $categories = Category::all();
        $selected_products = Product::where("id", ">", 15)->get();
        $products = [];
        foreach ($selected_products as $it) {
            array_push($products, (object)[
                'name'=> $it->name,
                'image_url'=> Image::firstWhere("product_id", $it->id)->url,
                'price' => Price::firstWhere("product_id", $it->id)->price / 100.0,
                'description' => Description::firstWhere("product_id", $it->id)->description
            ]);
        }
        return view("home", compact("categories", "products"));
    }
}
