<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCabinetController extends Controller
{
    //private $user;

    public function index() {
        $user = Auth::user();
        return view('cabinet.index', ['user' => $user]);
    }

    public function orders() {
        $user = User::where('id', Auth::id())->first(); //

        $orders = $user->orders()->get();
        return view('cabinet.orders', ['user'=> $user,'orders' => $orders]);
    }
}
