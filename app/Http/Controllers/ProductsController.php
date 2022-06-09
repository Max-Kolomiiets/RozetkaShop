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
        $price = Price::firstWhere("product_id", $product_id)->price;
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
            $attribute_alias = Attribute::find($characteristic->attribute_id)->alias;
            if(property_exists($attributes, $attribute_alias) &&
                in_array($characteristic->alias, $attributes->$attribute_alias))
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

    private function sortValuesIntoListsByAttributes($values)
    {
        $keyvalues = (object)[];
        foreach ($values as $key=>$value) {
            $keyvalue = explode( "-", $key);
            $key = $keyvalue[0];
            if(!property_exists($keyvalues, $key)){
                $keyvalues ->$key = [];
            }
            array_push($keyvalues ->$key, $value);
        }
        return $keyvalues;
    }

    public function show($id)
    {
        $product_id = $id;
        $product = Product::find($product_id);
        $images = Image::Where("product_id", $product_id)->limit(8)->get()->toArray();
        $image = (object)array_shift($images);
        $price = Price::firstWhere("product_id", $product_id)->price;
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

        $sortedList = $this->sortValuesIntoListsByAttributes($request_data);
        $filters = (object)[];
        if(property_exists($sortedList, 'vendor')){
            $vendor = $sortedList->vendor;
            $filters->vendors = $vendor;
            $mask_array = (array)$sortedList;
            if(count($mask_array) > 1)
            {
                array_shift($mask_array);
                $filters->attributes = (object)$mask_array;
            }
        }
        else {
            $filters->attributes = $sortedList;
        }

        $filters->prices = (object)[
            'min'=>$price_min,
            'max'=>$price_max
        ];
        return $this->search($title, $filters);
    }
}
