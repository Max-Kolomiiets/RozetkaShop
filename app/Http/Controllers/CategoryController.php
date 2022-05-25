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
use App\Models\CategoryAttribute;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category_id = 1;
    }
    
    public function getProductData(Product $product)
    {
        return (object)[
            'id'=>$product->id,
            'name'=> $product->name,
            'image_url'=> Image::firstWhere("product_id", $product->id)->url,
            'price' => Price::firstWhere("product_id", $product->id)->price / 100.0,
            'description' => Description::firstWhere("product_id", $product->id)->description
        ];
    }

    public function getFilltresValues($attribute_id, $products)
    {
        $selected_characteristics = Characteristic::where("attribute_id", $attribute_id)->get();
        $values = [];
        foreach ($selected_characteristics as $characteristic){
            $filter = function($product) use ($characteristic){
                return $characteristic->product_id == $product->id;
            };
            $filtred_products = array_filter($products, $filter);
            $filtred_products_cnt = count($filtred_products);
            if($filtred_products_cnt > 0){
                array_push($values, $characteristic->value);
            }
        }
        return array_unique($values);
    }

    public function filtingProduct($product_id, $filtres)
    {
        $characteristics = Characteristic::where('product_id', $product_id)->get();
        foreach ($characteristics as $characteristic) {
            $attribute_name = Attribute::find($characteristic->attribute_id)->name;
            if(property_exists($filtres, $attribute_name) &&
                in_array($characteristic->value, $filtres->$attribute_name))
            {
                return true;
            }
        }
        return false;
    }

    public function getCategoriesProducts($category_id)
    {
        $selected_products = Product::where("category_id", $category_id)->get();
        $products = [];
        foreach ($selected_products as $sproduct) {
            array_push($products, $this->getProductData($sproduct));
        }
        return $products;
    }

    public function uncheckAllFilterValues($values_list, $mask = null)
    {
        $values_states = [];
        foreach ($values_list as $value) {
            $value_state = (object)[
                'alias' => $value,
                'state' => [false, true][$mask != null && in_array($value, $mask)]
            ];
            array_push($values_states , $value_state);
        }
        return $values_states;
    }

    public function convertStringListToListsArray($keysvalues_in_string)
    {
        $keyvalues = (object)[];
        $keys = [];
        foreach ($keysvalues_in_string as $kvstring) {
            $keyvalue = explode( "#", $kvstring);
            $key = $keyvalue[0];
            $value = $keyvalue[1];
            if(!in_array($key, $keys)){
                array_push($keys, $key);
                $keyvalues ->$key = [];
            }
            array_push($keyvalues ->$key, $value);
        }
        return $keyvalues;
    }

    public function show( Category $category)
    {
        $products = $this->getCategoriesProducts($category->id);

        $selected_attributes = CategoryAttribute::where("category_Id", $category->id)->get();
        $attributes = [];
        foreach ($selected_attributes as $sattribute) {
            $values = $this->getFilltresValues($sattribute->attribute_id, $products);
            $values = $this->uncheckAllFilterValues($values);
            if(count($values) != 0){
                array_push($attributes, (object)[
                    'name'=>Attribute::find($sattribute->attribute_id)->name,
                    'values'=>$values,
                ]);
            }
        }
        return view("products", compact("category", "products", "attributes"));
    }

    public function filtering(Category $category)
    {
        $request_data = request()->all();
        array_shift($request_data);
        $changes = array_keys($request_data);
        $mask = $this->convertStringListToListsArray($changes);

        $products = $this->getCategoriesProducts($category->id);

        $selected_attributes = CategoryAttribute::where("category_Id", $category->id)->get();
        $attributes = [];
        foreach ($selected_attributes as $sattribute) {
            $attribute = Attribute::find($sattribute->attribute_id);
            $values = $this->getFilltresValues($attribute->id, $products);

            $key = $attribute->name;
            if(property_exists($mask, $key)){
                $values = $this->uncheckAllFilterValues($values, $mask->$key);
            }else{
                $values = $this->uncheckAllFilterValues($values);
            }
            
            if(count($values) != 0){
                array_push($attributes, (object)[
                    'name'=>$attribute->name,
                    'values'=>$values,
                ]);
            }
        }

        if(count((array)$mask) > 0){
            $products = array_filter($products, function ($p) use ($mask) {
                return $this->filtingProduct($p->id, $mask);
            });
        }

        return view("products", compact("category", "products", "attributes"));
    }
}