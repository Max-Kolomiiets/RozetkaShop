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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/main', "HomeController@index")->name("main.index");

Route::get('/categories/{category}', "CategoryController@show")->name("category.show");
Route::get('/products/{product}', "ProductsController@show")->name("product.show");

Route::post('/categories/{category}/filtering', "CategoryController@filtering")->name("category.filtering");