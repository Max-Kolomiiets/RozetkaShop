<?php

namespace App\Http\Controllers;

use App\Admin\Selectable\Products;
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
use App\Models\Vendor;
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

    public function search($title = null, $filters = null)
    {
        $word = 0;
        if($title == null)
        {
            $word = request()->all()['word'];
        }
        else
        {
            $word = $title;
        }

        $products = Product::where('name', 'LIKE', '%'.$word.'%')->get();
        if(count($products) > 0)
        {
            $DBcollector = new ProductsViewsInformationCollector();
            $view_info = $DBcollector->GetProductsViewInfo('search', $word, 'search', $products, $filters);
            if($filters != null)
            {
                $view_info->products = $this->filteringProducts($products, $filters);
            }
            return view("products", compact("view_info"));
        }
        else
        {
            $view_info = (object)['query_type' => 'none'];
            return view("products", compact("view_info"));
        }
    }

    public function filtering()
    {
        $request_data = request()->all();

        array_shift($request_data);

        $title = array_shift($request_data);
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

        return $this->search($title, $filters);
    }
}
