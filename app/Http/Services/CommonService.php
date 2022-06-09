<?php

namespace App\Http\Services;

use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CommonService
{
    public function existsInCart($prod_id) {

        if (Auth::check()) {
            if (CartProduct::where('product_id', $prod_id)->exists())
                return true;
            
            return false;
        }

        if (Cookie::get('shopping_cart'))
            $cart = json_decode(stripslashes(Cookie::get('shopping_cart')), true);
        else 
            return false;

        $ids = array_column($cart, 'item_id');
        if (in_array($prod_id, $ids)) {
            foreach ($cart as $cartItem) {
                if ($cartItem["item_id"] == $prod_id) 
                    return true;
            }
        }

        return false;
    }
}