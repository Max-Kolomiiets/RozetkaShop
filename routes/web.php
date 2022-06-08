<?php

use App\Models\Category;
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
Route::post('/categories/{category}/filtering', "CategoryController@filtering")->name("category.filtering");

Route::get('/products/search', "ProductsController@search")->name('products.search');
Route::post('/products/search/filtering', "ProductsController@filtering")->name('products.search.filtering');
Route::get('/products/{product}', "ProductsController@show")->name("product.show");

// for cookies cart
Route::get('/cart-total','CartController@getCartTotal');
Route::get('/cart','CartController@index')->name('cart.index');

Route::post('/add-to-cart','CartController@addToCart');
Route::post('update-cart','CartController@changeCartQuantity');

Route::delete('delete-from-cart','CartController@removeCartItem');
Route::get('clear-cart','CartController@clearCart');

// for user cabinet
function userCabinetRoute() {
    Route::get('/cabinet', 'UserCabinetController@index')->name('cabinet.index');
    Route::get('/cabinet/orders', 'UserCabinetController@orders')->name('cabinet.orders');
    Route::get('/cabinet/wishlist', 'UserCabinetController@index')->name('cabinet.wishlist');
}


Route::get('/categories', "CategoryController@index")->name("category.index");

Route::get('/checkout', 'CartController@checkout')->name('checkout');
Route::post('/make-order','CartController@makeOrder');

// upload json for products

Route::post('/upload-products', 'UploadController@uploadProductsJson')->name('upload.products');
Route::post('/upload-images', 'UploadController@uploadImagesAndJsonFile')->name('upload.images');

// categories test
Route::get('/categories', function () {
    $categories = Category::tree()->get()->toTree();
 
    return view('categories', [
        'categories' => $categories
    ]);
});