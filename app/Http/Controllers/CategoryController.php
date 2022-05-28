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
use App\Models\Vendor;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index')->with('categories', Category::all());
    }
    
    private function getMinMaxPrices($products)
    {
        $prices = [];
        foreach ($products as $product) {
            array_push($prices, Price::firstWhere("product_id", $product->id)->price);
        }
        $min_max_prices = (object)[
            'min' => min($prices)/100.0,
            'max' => max($prices)/100.0
        ];
        return $min_max_prices;
    }

    private function getVendors($products)
    {
        $vendors = [];
        foreach ($products as $product) {
            array_push($vendors, Vendor::find($product->vendor_id));
        }
        return array_unique($vendors);
    }

    private function getProductData(Product $product)
    {
        return (object)[
            'id'=>$product->id,
            'name'=> $product->name,
            'vendor_id'=>$product->vendor_id,
            'image_url'=> Image::firstWhere("product_id", $product->id)->url,
            'price' => Price::firstWhere("product_id", $product->id)->price / 100.0,
            'description' => Description::firstWhere("product_id", $product->id)->description
        ];
    }

    private function getFiltersValues($attribute_id, $products)
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

    private function filteringProductByPrice($product_id, $prices)
    {
        $price = Price::firstWhere("product_id", $product_id)->price/100.0;
        return $prices->min <= $price && $price <= $prices->max;
    }

    private function filteringProductByVendors($vendor_id, $vendors)
    {
        $vendor = Vendor::find($vendor_id)->alias;
        return in_array($vendor, $vendors);
    }   

    private function filteringProductByAttrbutes($product_id, $attributes)
    {
        $characteristics = Characteristic::where('product_id', $product_id)->get();
        foreach ($characteristics as $characteristic) {
            $attribute_name = Attribute::find($characteristic->attribute_id)->name;
            if(property_exists($attributes, $attribute_name) &&
                in_array($characteristic->value, $attributes->$attribute_name))
            {
                return true;
            }
        }
        return false;
    }

    private function filteringProducts($products, $filters)
    {
        $filtered_products = [];
        foreach ($products as $product) {
            $isInFilter = true;
            if(property_exists($filters, 'vendor') && count((array)$filters->vendor)>0)
            {
                $isInFilter &= $this->filteringProductByVendors($product->vendor_id, $filters->vendor);
            }
            if(property_exists($filters, 'filters') && count((array)$filters->filters)>0)
            {
                $isInFilter &= $this->filteringProductByAttrbutes($product->id, $filters->filters);
            }
            $isInFilter &= $this->filteringProductByPrice($product->id, $filters->price);
            if($isInFilter)
            {
                array_push($filtered_products, $product);
            }
        }
        return $filtered_products;
    }

    private function getCategoriesProducts($category_id)
    {
        $selected_products = Product::where("category_id", $category_id)->get();
        $products = [];
        foreach ($selected_products as $sproduct) {
            array_push($products, $this->getProductData($sproduct));
        }
        return $products;
    }

    private function uncheckAllFilterValues($values_list, $mask = null)
    {
        $values_states = [];
        foreach ($values_list as $value) {
            $value_state = (object)[
                'alias' => $value,
                'state' => ($mask != null && in_array($value, $mask))
            ];
            array_push($values_states , $value_state);
        }
        return $values_states;
    }

    private function convertStringListToListsArray($keysvalues_in_string)
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

    private function getFiltersForm($category_id, $products, $filters = null)
    {
        $prices = $this->getMinMaxPrices($products);

        if($filters == null){
            $prices->value_min = $prices->min;
            $prices->value_max = $prices->max;
        }
        else{
            $prices->value_min = $filters->price->min;
            $prices->value_max = $filters->price->max;
        }

        $vendors = $this->getVendors($products);
        $vendors_forms = [];
        foreach ($vendors as $vendor) {
            array_push($vendors_forms, (object)[
                'name' => $vendor->name,
                'alias' => $vendor->alias,
                'state' => ($filters != null && property_exists($filters, 'vendor') && in_array($vendor->alias, $filters->vendor))
            ]);
        }

        $selected_attributes = CategoryAttribute::where("category_id", $category_id)->get();
        $attributes = [];
        foreach ($selected_attributes as $sattribute) {
            $values = $this->getFiltersValues($sattribute->attribute_id, $products);
            $attribute = Attribute::find($sattribute->attribute_id);
            $key = $attribute->name;
            if($filters != null && property_exists($filters, 'filters') && property_exists($filters->filters, $key)){
                $values = $this->uncheckAllFilterValues($values, $filters->filters->$key);
            }else{
                $values = $this->uncheckAllFilterValues($values);
            }
            if(count($values) != 0){
                array_push($attributes, (object)[
                    'name'=>Attribute::find($sattribute->attribute_id)->name,
                    'values'=>$values,
                ]);
            }
        }

        $formstates = (object)[
            'prices' => $prices,
            'vendors' => $vendors_forms,
            'attributes' => $attributes
        ];

        return $formstates;
    }

    public function show(Category $category, $filters = null)
    {
        $products = $this->getCategoriesProducts($category->id);
        $formstates = $this->getFiltersForm($category->id, $products, $filters);

        if($filters != null)
        {
            $products = $this->filteringProducts($products, $filters);
        }

        return view("products", compact("category", "products", "formstates"));
    }

    public function filltering(Category $category)
    {
        //приймає данні з форми
        $request_data = request()->all();

        //видалаяє данні токена з масива
        array_shift($request_data);

        $price_min = array_shift($request_data);
        $price_max = array_shift($request_data);

        //бере ключі з масива (так як значення завжди має бути "on")
        $changes = array_keys($request_data);

        //примає масив строк типу [key1#value1, key1#value2, key2#value1] 
        //і перетворює його в обєкт типу [key1= [value1, value2], key2 = [value1]]
        $mask = $this->convertStringListToListsArray($changes);

        //відділяє "vendor" фільтри від фітрів по атрибутам 
        $filters = (object)[];
        $vendor = [];
        if(property_exists($mask, 'vendor')){
            $vendor = $mask->vendor;
            $filters->vendor = $vendor;
            $mask_array = (array)$mask;
            if(count($mask_array) > 1)
            {
                array_shift($mask_array);
                $filters->filters = (object)$mask_array;
            }
        }
        else {
            $filters->filters = $mask;
        }

        $filters->price = (object)[
            'min'=>$price_min,
            'max'=>$price_max
        ];
        return $this->show($category, $filters);
    }
}