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
        return view('cart.index')
            ->with('cart_data', $cart_data);
    }

    public function addtocart(Request $request)
    {
        $prod_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (Auth::check()) {

            if (CartProduct::where('product_id', $prod_id)->exists())
                return response()->json(['status' => '"' . Product::find($prod_id)->name . '" Already Added to Cart', 'status2' => '2']);

            $cartProduct = CartProduct::create([
                'user_id' => Auth::id(),
                'product_id' => $prod_id,
                'qty' => $quantity
            ]);

            if ($cartProduct)
                return response()->json(['status' => '"' . Product::find($prod_id)->name . '" Added to Cart']);
        }

        if (Cookie::get('shopping_cart')) {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);
        } else {
            $cart_data = array();
        }

        $item_id_list = array_column($cart_data, 'item_id');
        $prod_id_is_there = $prod_id;

        if (in_array($prod_id_is_there, $item_id_list)) {
            foreach ($cart_data as $keys => $values) {
                if ($cart_data[$keys]["item_id"] == $prod_id) {
                    return response()->json(['status' => '"' . $cart_data[$keys]["item_name"] . '" Already Added to Cart', 'status2' => '2']);
                }
            }
        } else {
            $product = Product::find($prod_id);
            $prod_name = $product->name;
            $prod_image = $product->images()->first()->url;
            $priceval = $product->price()->get()[0]->price;

            if ($product) {
                $item_array = array(
                    'item_id' => $prod_id,
                    'item_name' => $prod_name,
                    'item_quantity' => $quantity,
                    'item_price' => $priceval,
                    'item_image' => $prod_image
                );
                $cart_data[] = $item_array;

                $item_data = json_encode($cart_data);
                $minutes = 60;
                Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                return response()->json(['status' => '"' . $prod_name . '" Added to Cart']);
            }
        }
    }

    public function cartloadbyajax()
    {
        if (Auth::check()) {
            $user = User::where('id', Auth::id())->first();
            $totalcart = $user->cartProducts()->get()->count();

            echo json_encode(array('totalcart' => $totalcart));
            die;
            return;
        }

        if (Cookie::get('shopping_cart')) {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);
            $totalcart = count($cart_data);

            echo json_encode(array('totalcart' => $totalcart));
            die;
            return;
        } else {
            $totalcart = "0";
            echo json_encode(array('totalcart' => $totalcart));
            die;
            return;
        }
    }

    public function updatetocart(Request $request)
    {
        $prod_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (Auth::check()) {
            $cartProduct = CartProduct::find($prod_id);
            $product = Product::find($cartProduct->product()->get()[0]->id);

            if ($cartProduct && $product) {
                $cartProduct->qty = $quantity;
                $cartProduct->save();

                return response()->json(['status' => '"' . $product->name . '" Quantity Updated']);
            }
        }

        if (Cookie::get('shopping_cart')) {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);

            $item_id_list = array_column($cart_data, 'item_id');
            $prod_id_is_there = $prod_id;

            if (in_array($prod_id_is_there, $item_id_list)) {
                foreach ($cart_data as $keys => $values) {
                    if ($cart_data[$keys]["item_id"] == $prod_id) {
                        $cart_data[$keys]["item_quantity"] =  $quantity;
                        $item_data = json_encode($cart_data);
                        $minutes = 60;
                        Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                        return response()->json(['status' => '"' . $cart_data[$keys]["item_name"] . '" Quantity Updated']);
                    }
                }
            }
        }
    }

    public function deletefromcart(Request $request)
    {
        $prod_id = $request->input('product_id');

        if (Auth::check()) {
            if (CartProduct::find($prod_id)->delete())
                return response()->json(['status' => 'Item Removed from Cart']);

            return response()->json(['status' => 'Something went wrong! We are so sorry)']);
        }

        $cookie_data = stripslashes(Cookie::get('shopping_cart'));
        $cart_data = json_decode($cookie_data, true);

        $item_id_list = array_column($cart_data, 'item_id');
        $prod_id_is_there = $prod_id;

        if (in_array($prod_id_is_there, $item_id_list)) {
            foreach ($cart_data as $keys => $values) {
                if ($cart_data[$keys]["item_id"] == $prod_id) {
                    unset($cart_data[$keys]);
                    $item_data = json_encode($cart_data);
                    $minutes = 60;
                    Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                    return response()->json(['status' => 'Item Removed from Cart']);
                }
            }
        }
    }

    public function clearcart()
    {
        if (Auth::check()) {
            CartProduct::truncate();
            return response()->json(['status' => 'Your Cart is Cleared']);
        }

        Cookie::queue(Cookie::forget('shopping_cart'));
        return response()->json(['status' => 'Your Cart is Cleared']);
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

    public function makeOrder(Request $request) {
        if (Auth::check()) {
            // create new order for user 
            // take data from the cart!

            $user = User::where('id', Auth::id())->first();
            $userCart = $user->cartProducts()->get();

            if (is_null($userCart) || empty($userCart))
                return;
            
            $orderNumber = Order::exists() ? Order::latest('id')->first()->id + 1 : 1;

            $order = new Order;
            $order->order_number = $orderNumber;
            $order->order_date = date('Y-m-d H:i:s');
            $order->user_id = $user->id;
            $order->order_status_id = 1;
            $order->save();

            foreach ($userCart as $cart) 
            {
                $orderProduct = new OrderProduct;
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $cart->product_id;
                $orderProduct->qty = $cart->qty;
                $orderProduct->save();
            }

            CartProduct::truncate();
            return response()->json(['status' => "Thank you for your order! We'll be in touch"]);
        }
        return response()->json(['status' => 'Thank you for your order!']);
    }
}
