<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserCabinetController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::id())->first();
        $orders = $user->orders()->get();

        return view('cabinet.index', ['user' => $user, 'orders' => $orders]);
    }

    public function updateUserInfo(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'login'           => 'required',
            'name'           => 'required',
            'lastname'           => 'required',
            'email'          => 'required',
            'phone'        => 'required',
            'address'        => 'required',
        ]);

        if ($validator->fails()) {

            $response['status'] = 'Помилка! Щось пішло не так';
            $response['code'] = -1;
        } else {
            $response['status'] = 'Ваші дані були оновлені!';
            $response['code'] = 1;

            $user = User::find(Auth::id());
            $userContacts = Contact::find($user->contacts()->first()->id);

            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $userContacts->phone = $request->phone;
            $userContacts->address = $request->address;

            $user->save();
            $userContacts->save();
        }

        return response()->json($response);
    }
}
