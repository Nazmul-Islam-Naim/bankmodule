<?php

use App\Http\Controllers\Api\V1\Vendors\AuthController;
use App\Http\Controllers\Api\V1\Vendors\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Authentication
Route::group(['prefix'=>'auth'],function(){
    Route::post('registration',[AuthController::class,'registration'])->middleware('guest:vendor');
    Route::post('login',[AuthController::class,'login'])->middleware('guest:vendor');
    Route::group(['middleware'=>['auth:vendor']],function(){
        Route::get('me',[AuthController::class,'me']);
        Route::post('logout',[AuthController::class,'logout']);
    });
});

//commons



Route::group(['middleware'=>['auth:vendor']],function(){// Settings

    Route::get('shop/show',[VendorController::class,'getShop']);
    Route::get('addresses',[VendorController::class,'getAddresses']);
    Route::get('businessinfo',[VendorController::class,'getBusinessInfo']);

    //settings
    Route::group(['prefix'=>'settings'],function(){
        //accounts
        route::group(['prefix'=>'accounts'],function(){
            Route::put('shop/update',[VendorController::class,'updateShop']);
            Route::put('address/update',[VendorController::class,'updateAddress']);
            Route::put('business/update',[VendorController::class,'updateBusiness']);
        });
    });
});


