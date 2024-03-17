<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

// JWT Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('user-profile', 'userProfile');
    Route::post('refresh', 'refresh');
});

// Brand Crud
Route::group(['prefix'=>'brand'], function($router){
    Route::controller(BrandController::class)->group(function(){
        Route::get('index', 'index')->middleware('auth');
        Route::get('show/{id}', 'show')->middleware('auth');
        Route::post('store', 'store')->middleware('is_admin');
        Route::put('update/{id}', 'update')->middleware('is_admin');
        Route::delete('delete/{id}', 'delete')->middleware('is_admin');
    });
});


// Category Crud
Route::group(['prefix'=>'category'], function($router){
    Route::controller(CategoryController::class)->group(function () {
        Route::get('index', 'index')->middleware('auth');
        Route::get('show/{id}', 'show')->middleware('auth');
        Route::post('store', 'store')->middleware('is_admin');
        Route::put('update/{id}', 'update')->middleware('is_admin');
        Route::delete('delete/{id}', 'delete')->middleware('is_admin');
    });
});

// Location
Route::group(['prefix'=>'location'], function($router){
    Route::controller(LocationController::class)->group(function () {
        Route::post('store', 'store')->middleware('auth');
        Route::put('update/{id}', 'update')->middleware('auth');
        Route::delete('delete/{id}', 'delete')->middleware('auth');
    });
});

// product Crud
Route::group(['prefix'=>'product'], function($router){
    Route::controller(ProductController::class)->group(function () {
        Route::get('index', 'index')->middleware('auth');
        Route::get('show/{id}', 'show')->middleware('auth');
        Route::post('store', 'store')->middleware('is_admin');
        Route::put('update/{id}', 'update')->middleware('is_admin');
        Route::delete('delete/{id}', 'delete')->middleware('is_admin');
    });
});

// order Crud
Route::group(['prefix'=>'order'], function($router){
    Route::controller(OrderController::class)->group(function () {
        Route::get('index', 'index')->middleware('is_admin');
        Route::get('show/{id}', 'show')->middleware('is_admin');
        Route::post('store', 'store')->middleware('auth');
        Route::get('get_order_items/{id}', 'get_order_items')->middleware('is_admin');
        Route::get('get_user_orders/{id}', 'get_user_orders')->middleware('is_admin');
        Route::put('change_order_status/{id}', 'change_order_status')->middleware('is_admin');
    });
});
