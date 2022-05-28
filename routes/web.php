<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "HomeController@index")->name("main.index");


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    userCabinetRoute();
});
Route::get('/main', "HomeController@index")->name("main.index");

Route::get('/categories/{category}', "CategoryController@show")->name("category.show");
Route::get('/products/{product}', "ProductsController@show")->name("product.show");

Route::post('/categories/{category}/filltering', "CategoryController@filltering")->name("category.filltering");
Route::post('/search', "HomeController@search")->name('search');


// for cookies cart
Route::get('/load-cart-data','CartController@cartloadbyajax');
Route::get('/cart','CartController@index')->name('cart.index');

Route::post('/add-to-cart','CartController@addtocart');
Route::post('update-to-cart','CartController@updatetocart');

Route::delete('delete-from-cart','CartController@deletefromcart');
Route::get('clear-cart','CartController@clearcart');

// for user cabinet
function userCabinetRoute() {
    Route::get('/cabinet', 'UserCabinetController@index')->name('cabinet.index');
    Route::get('/cabinet/orders', 'UserCabinetController@orders')->name('cabinet.orders');
    Route::get('/cabinet/wishlist', 'UserCabinetController@index')->name('cabinet.wishlist');
}


Route::get('/categories', "CategoryController@index")->name("category.index");

Route::get('/checkout', 'CartController@checkout')->name('checkout');
Route::post('make-order','CartController@makeOrder');
