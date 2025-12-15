<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BroadcastMessageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    Route::post('login/otp/send',[AuthController::class,'loginOtpSend']);
    Route::post('login',[AuthController::class,'login']);

    Route::get('brands',[BrandController::class,'index']);
    Route::get('categories',[CategoryController::class,'index']);
    Route::get('products',[ProductController::class,'index']);
    Route::get('product/sliders',[ProductController::class,'productSliders']);



    // the following api need authentication
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('wishlist',[UserProductController::class,'userWishList']);
        Route::post('add/wishlist',[UserProductController::class,'addWishList']);
        Route::post('remove/wishlist',[UserProductController::class,'removeProductFromWishList']);

        Route::get('carts',[ShoppingCartController::class,'index']);
        Route::post('add/cart',[ShoppingCartController::class,'addToCart']);
        Route::post('remove/cart',[ShoppingCartController::class,'removeToCart']);
        Route::get('clear/cart',[ShoppingCartController::class,'flashCart']);

        Route::get('/me', [UserController::class, 'me']);
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::apiResource('users', UserController::class);
    });


    Route::post('/broadcast/send/message', [BroadcastMessageController::class, 'bradcastMessage']);




    Route::get('success',function(){
        // order payment success update
        return response()->json(['message'=>'success']);
    });

    Route::get('failed',function(){
        return response()->json(['message'=>'failed']);
    });

    Route::get('cancel',function(){

        return response()->json(['message'=>'cancel']);
    });

    Route::get('ipn',function(){
        return response()->json(['message'=>'ipn']);
    });
});
