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
        $category_id = 1;
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
            if(property_exists($filters, 'vendors') && count((array)$filters->vendors)>0)
            {
                $isInFilter &= $this->filteringProductByVendors($product->vendor_id, $filters->vendors);
            }
            if(property_exists($filters, 'attributes') && count((array)$filters->attributes)>0)
            {
                $isInFilter &= $this->filteringProductByAttrbutes($product->id, $filters->attributes);
            }
            $isInFilter &= $this->filteringProductByPrice($product->id, $filters->prices);
            if($isInFilter)
            {
                $DBcollector = new ProductsViewsInformationCollector();
                array_push($filtered_products, $DBcollector->ConvertProductToProductData($product));
            }
        }
        return $filtered_products;
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

    private function tempBugFixingMethod($attributs_array)
    {
        $new_array = (object)[];
        foreach ($attributs_array as $key=>$value) {
            $new_key = str_replace('_', ' ', $key);
            $new_velue = str_replace('_',' ', $value);
            $new_array->$new_key = $new_velue;
        }
        return $new_array;
    }

    public function show(Category $category, $filters = null)
    {
        $products = Product::where("category_id", $category->id)->get();

        $DBcollector = new ProductsViewsInformationCollector();
        $view_info = $DBcollector->GetProductsViewInfo('show', $category->name, $category->id, $products, $filters);

        if($filters != null)
        {
            $view_info->products = $this->filteringProducts($products, $filters);
        }
        return view("products", compact("view_info"));
    }

    public function filtering(Category $category)
    {
        $request_data = request()->all();
        array_shift($request_data);

        $price_min = array_shift($request_data);
        $price_max = array_shift($request_data);

        $changes = array_keys($request_data);

        $mask = $this->convertStringListToListsArray($changes);

        $filters = (object)[];
        if(property_exists($mask, 'vendor')){
            $vendor = $mask->vendor;
            $filters->vendors = $vendor;
            $mask_array = (array)$mask;
            if(count($mask_array) > 1)
            {
                array_shift($mask_array);
                $filters->attributes = (object)$mask_array;
            }
        }
        else {
            $filters->attributes = $mask;
        }
        if(property_exists($filters, 'attributes'))
        {
            $filters->attributes = $this->tempBugFixingMethod($filters->attributes);
        }
        $filters->prices = (object)[
            'min'=>$price_min,
            'max'=>$price_max
        ];

        return $this->show($category, $filters);
    }
}