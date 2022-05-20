<?php

use Illuminate\Routing\Router;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('categories', CategoryController::class);
    $router->resource('products', ProductController::class);
    $router->resource('users', UserController::class);
    $router->resource('cart', CartController::class);
    $router->resource('wish-list', WishListController::class);
    $router->resource('vendors', VendorController::class);
    $router->resource('countries', CountryController::class);
    $router->resource('availabilities', AvailabilityController::class);
    $router->resource('images', ImagesController::class);
    $router->resource('attributes', AttributeController::class);
});
