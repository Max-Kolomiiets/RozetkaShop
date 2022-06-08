<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Characteristic;
use App\Models\Description;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use App\Models\Vendor;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ProductsViewsInformationCollector
{
    //collect data from date base
    private function getProductsData($products)
    {
        $products_list = [];
        foreach ($products as $product) {
            array_push($products_list, $this->ConvertProductToProductData($product));
        }
        return $products_list;
    }
    private function getMinMaxPrices($products, $filters=null)
    {
        $prices = [];
        foreach ($products as $product) {
            array_push($prices, Price::firstWhere("product_id", $product->id)->price);
        }

        if(count($products)>1){
            $min_max_prices = (object)[
                'min' => min($prices)/100.0,
                'max' => max($prices)/100.0
            ];
        }
        else{
            $min_max_prices = (object)[
                'min' => $prices[0]/100.0,
                'max' => $prices[0]/100.0
            ];
        }

        if($filters == null){
            $min_max_prices->value_min = $min_max_prices->min;
            $min_max_prices->value_max = $min_max_prices->max;
        }
        else{
            $min_max_prices->value_min = $filters->prices->min;
            $min_max_prices->value_max = $filters->prices->max;
        }

        return $min_max_prices;
    }

    private function getVendorsData($products, $filters=null)
    {
        $vendors_list = [];
        $unique_control_array = [];
        foreach ($products as $product) {
            $vendor = Vendor::find($product->vendor_id);
            if(!in_array($vendor->alias, $unique_control_array))
            {
                array_push($unique_control_array, $vendor->alias);
                array_push($vendors_list, (object)[
                    'name' => $vendor->name,
                    'alias' => $vendor->alias,
                    'state' => ($filters != null && property_exists($filters, 'vendors') && in_array($vendor->alias, $filters->vendors))
                ]);
            }
        }
        return $vendors_list;
    }

    private function getCharacteristicsData($products, $filters=null)
    {
        $characteristics_list = (object)[];
        $unique_control_array = [];
        foreach ($products as $product) {
            $products_characteristics = Characteristic::where('product_id', $product->id)->get();
            foreach ($products_characteristics as $characteristic) {
                $attribute = Attribute::find($characteristic->attribute_id);
                $key = $attribute->id;
                if(!property_exists($characteristics_list, $attribute->id)){                                
                    $characteristics_list->$key = [];
                }
                if(!in_array($characteristic->alias, $unique_control_array))
                {
                    array_push($unique_control_array, $characteristic->alias);
                    array_push($characteristics_list->$key, (object)[
                        'id'=> $characteristic->id,
                        'alias'=> $characteristic->alias,
                        'name'=> $characteristic->value,
                        'state'=>$this->checkCharacteristicInFilters($characteristic->alias, $attribute->alias, $filters)
                    ]);
                }

            }
        }
        return $characteristics_list;
    }

    //tools
    private function checkCharacteristicInFilters($characteristic_alias, $attribut_alias, $filters=null)
    {
        if($filters==null)
        {
            return false;
        }
        if(!property_exists($filters, 'attributes'))
        {
            return false;
        }
        if(!property_exists($filters->attributes, $attribut_alias))
        {
            return false;
        }
        if(in_array($characteristic_alias, $filters->attributes->$attribut_alias))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //general methods
    public function GetProductsViewInfo($query_type, $title, $url_part, $products, $filters=null)
    { 
        $title_for_view = $title;
        $products_info_for_view = $this->getProductsData($products);
        $prices_info_for_view = $this->getMinMaxPrices($products, $filters);
        $vendors_info_for_view = $this->getVendorsData($products, $filters);
        $characteristics_info_for_view = $this->getCharacteristicsData($products, $filters);

        $view_info = (object)[
            'query_type' => $query_type,
            'title' => $title_for_view,
            'products'=>$products_info_for_view,
            'prices'=>$prices_info_for_view,
            'vendors'=>$vendors_info_for_view,
            'characteristics'=>$characteristics_info_for_view,
            'url part'=> $url_part
        ];
        //$view_info->{'url part'};
        return $view_info;
    }

    public function ConvertProductToProductData(Product $product)
    {
        return (object)[
            'id' => $product->id,
            'name' => $product->name,
            'vendor_id' => $product->vendor_id,
            'category_id' => $product->category_id,
            'image_url' => Image::firstWhere("product_id", $product->id)->url,
            'price' => Price::firstWhere("product_id", $product->id)->price / 100.0,
            'description' => Description::firstWhere("product_id", $product->id)->description
        ];
    }
}
