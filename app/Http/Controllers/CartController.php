<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::where('id', Auth::id())->first();

            $userCart = $user->cartProducts()->get();
            $cartDto = [];

            foreach ($userCart as $cart) {
                $productPrice = $cart->product()->get()[0]->price()->get()[0]->price;
                $productImage = $cart->product()->get()[0]->images()->get()[0]->url;

                $cartDto[] = array(
                    'item_id' => $cart->id,
                    'product_id' => $cart->product()->get()[0]->id,
                    'item_name' => $cart->product()->get()[0]->name,
                    'item_quantity' => $cart->qty,
                    'item_price' => $productPrice,
                    'item_image' => $productImage
                );
            }

            return view('cart.index')
                ->with('cart_data', $cartDto);
        }

        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
        $cart_data = json_decode($cookie_data, true);

        if (!empty($cart_data)) {
            foreach ($cart_data as $index => $cart_item) {
                $prod_id = $cart_data[$index]['item_id'];
                $cart_data[$index]['item_name'] = Product::find($prod_id)->name;
            }
        }

        return view('cart.index')
            ->with('cart_data', $cart_data);
    }

    public function addToCart(Request $request)
    {
        $prod_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (Auth::check()) {

            if (CartProduct::where('product_id', $prod_id)->exists())
                return response()->json(['status' => '"' . Product::find($prod_id)->name . '" ?????? ?? ?? ????????????!', 'code' => -1]);

            $cartProduct = CartProduct::create([
                'user_id' => Auth::id(),
                'product_id' => $prod_id,
                'qty' => $quantity
            ]);

            if ($cartProduct)
                return response()->json(['status' => '"' . Product::find($prod_id)->name . '" ?????? ?????????????? ???? ??????????????!', 'code' => 1]);
        }

        if (Cookie::get('shopping_cart'))
            $cart = json_decode(stripslashes(Cookie::get('shopping_cart')), true);
        else 
            $cart = array();

        $ids = array_column($cart, 'item_id');

        if (in_array($prod_id, $ids)) {
            foreach ($cart as $cartItem) {
                if ($cartItem["item_id"] == $prod_id) 
                    return response()->json(['status' => '"' . Product::find($prod_id)->name . '" ?????? ?? ?? ????????????!', 'code' => -1]);
            }
        } 

        $product = Product::find($prod_id);
        $prod_name = $product->name;
        $prod_image = $product->images()->first()->url;
        $price = $product->price()->get()[0]->price;

        if ($product) {
            $newCartItem = array(
                'item_id' => $prod_id,
                'item_name' => $prod_name,
                'item_quantity' => $quantity,
                'item_price' => $price,
                'item_image' => $prod_image
            );
            $cart[] = $newCartItem;
            Cookie::queue(Cookie::make('shopping_cart', json_encode($cart), 1440));

            return response()->json(['status' => '"' . $prod_name . '" ?????? ?????????????? ???? ??????????????!', 'code' => 1]);
        }

        return response()->json(['status' => '???????? ?????????? ???? ??????', 'code' => -1]);
    }

    public function getCartTotal()
    {
        $response = array();

        if (Auth::check()) {
            $user = User::where('id', Auth::id())->first();
            $cartTotal = $user->cartProducts()->sum('qty');

            if ($cartTotal == 0) $cartTotal = '';

            $response['cartTotal'] = $cartTotal;
            return response()->json($response);
        }

        if (Cookie::get('shopping_cart')) {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);
            $cartTotal = array_sum(array_column($cart_data,'item_quantity'));

            if ($cartTotal == 0) $cartTotal = '';

            $response['cartTotal'] = $cartTotal;
        } else
            $response['cartTotal'] = '';

        return response()->json($response);
    }

    public function changeCartQuantity(Request $request)
    {
        $prod_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (Auth::check()) {
            $cartProduct = CartProduct::find($prod_id);
            if ($cartProduct == null) 
                return response()->json(['status' => '???????? ?????????? ???? ??????!',  'code' => -1]);

            $product = Product::find($cartProduct->product()->first()->id);

            if ($product) {
                $cartProduct->qty = $quantity;
                $cartProduct->save();

                return response()->json(['status' => '"' . $product->name . '" ?????????????????? ???????????? ???????? ??????????????',  'code' => 1]);
            }
        }

        if (Cookie::get('shopping_cart')) {
            $cart = json_decode(stripslashes(Cookie::get('shopping_cart')), true);
            $ids = array_column($cart, 'item_id');

            if (in_array($prod_id, $ids)) {

                foreach ($cart as $index => $cartItem) {

                    if ($cart[$index]["item_id"] == $prod_id) {

                        $cart[$index]["item_quantity"] =  $quantity;
                        Cookie::queue(Cookie::make('shopping_cart', json_encode($cart), 1440));

                        return response()->json(['status' => '"' . Product::find($prod_id)->name . '" ?????????????????? ???????????? ???????? ??????????????',  'code' => 1]);
                    }
                }
            }
        }
        return response()->json(['status' => '???????? ?????????? ???? ??????',  'code' => -1]);
    }

    public function removeCartItem(Request $request)
    {
        $prod_id = $request->input('product_id');

        if (Auth::check()) {
            if (CartProduct::find($prod_id)->delete())
                return response()->json(['status' => '?????????? ?????? ?????????????????? ?? ??????????????!']);

            return response()->json(['status' => '???????? ?????????? ???? ??????']);
        }

        $cart = json_decode(stripslashes(Cookie::get('shopping_cart')), true);
        $ids = array_column($cart, 'item_id');

        if (in_array($prod_id, $ids)) {
            foreach ($cart as $index => $cartItem) {
                if ($cartItem["item_id"] == $prod_id) {

                    unset($cart[$index]);
                    Cookie::queue(Cookie::make('shopping_cart', json_encode($cart), 1440));

                    return response()->json(['status' => '?????????? ?????? ?????????????????? ?? ??????????????!']);
                }
            }
        }
    }

    public function clearCart()
    {
        if (Auth::check()) {
            CartProduct::truncate();
            return response()->json(['status' => '???????? ?????????????? ??????????????!']);
        }

        Cookie::queue(Cookie::forget('shopping_cart'));
        return response()->json(['status' => '???????? ?????????????? ??????????????!']);
    }

    public function checkout()
    {
        if (Auth::check()) {
            $user = User::where('id', Auth::id())->first();
            $userCart = $user->cartProducts()->get();

            $cartDto = [];

            foreach ($userCart as $cart) {
                $productPrice = $cart->product()->get()[0]->price()->get()[0]->price;
                $productImage = $cart->product()->get()[0]->images()->get()[0]->url;
                $cartDto[] = array(
                    'item_id' => $cart->id,
                    'product_id' => $cart->product()->get()[0]->id,
                    'item_name' => $cart->product()->get()[0]->name,
                    'item_quantity' => $cart->qty,
                    'item_price' => $productPrice,
                    'item_image' => $productImage
                );
            }

            return view('cart.checkout')
                ->with('cart_data', $cartDto);
        }

        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
        $cart_data = json_decode($cookie_data, true);

        return view('cart.checkout')
            ->with('cart_data', $cart_data);
    }

    public function makeOrder(Request $request)
    {
        if (Auth::check()) {
            $user = User::where('id', Auth::id())->first();
            $userCart = $user->cartProducts()->get();

            if (is_null($userCart) || empty($userCart))
                return response()->json(['status' => "?????????? ??????????????!", 'code' => -1]);

            $orderNumber = Order::exists() ? Order::latest('id')->first()->id + 1 : 1;

            $order = new Order;
            $order->order_number = $orderNumber;
            $order->order_date = date('Y-m-d H:i:s');
            $order->user_id = $user->id;
            $order->order_status_id = 1;
            $order->save();

            foreach ($userCart as $cart) {
                $orderProduct = new OrderProduct;
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $cart->product_id;
                $orderProduct->qty = $cart->qty;
                $orderProduct->save();
            }

            CartProduct::truncate();
            return response()->json(['status' => "?????????????? ???? ???????? ????????????????????! ???? ?? ???????? ????'??????????????", 'code' => 1]);
        }
        return response()->json(['status' => '?????????????? ???? ???????? ????????????????????!', 'code' => 1]);
    }
}
