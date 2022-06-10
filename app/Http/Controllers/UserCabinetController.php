<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCabinetController extends Controller
{
    //private $user;

    public function index() {
        $auth_data = Auth::user();
        $user = User::where('id', Auth::id())->first();
        $orders = $user->orders()->get();
        return view('cabinet.index', ['user' => $auth_data,'orders' => $orders]);
    }

    // public function orders() {
    //     $user = User::where('id', Auth::id())->first();
    //     $orders = $user->orders()->get();        
    //     $products = $orders[0]->products()->get();
    //     return view('cabinet.orders', ['user'=> $user,'orders' => $orders]);
    // }
}
