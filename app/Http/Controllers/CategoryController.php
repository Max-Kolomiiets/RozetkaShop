<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Price;
use App\Models\Product;
use App\Models\Characteristic;
use App\Models\Attribute;
use App\Models\Vendor;
use App\Http\Services\CommonService;

class CategoryController extends Controller
{
    private CommonService $service;
     public function index()

    {
        $categories = Category::tree()->get()->toTree();
        return view('categories.index')->with('categories', $categories);

        // $rootCategories = Category::where('parent_id', null)->get();

        // //dd($rootCategories[0]->children()->get());

        // return view('categories.index')->with('categories', $rootCategories);

    }
    

    public function __construct() {
        $this->service = new CommonService();
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

    public function show(Category $category, $filters = null)
    {
        $products = Product::where("category_id", $category->id)->get();

        $DBcollector = new ProductsViewsInformationCollector();
        $view_info = $DBcollector->GetProductsViewInfo('show', $category->name, $category->id, $products, $filters);
        if($filters != null)
        {
            $view_info->products = $this->filteringProducts($products, $filters);
        }

        foreach ($view_info->products as $product) {
            $product->inCart = $this->service->existsInCart($product->id);
        }

        return view("products", compact("view_info"));
    }

    public function filtering(Category $category)
    {
        $request_data = request()->all();

        array_shift($request_data); //remove _token
        $price_min = array_shift($request_data); //shift min price value
        $price_max = array_shift($request_data); //shift max price value

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

        return $this->show($category, $filters);
    }
}