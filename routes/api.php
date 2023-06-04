<?php

use App\Http\Controllers\Api\V1\Global\AuthController;
use App\Http\Controllers\Api\V1\Global\GlobalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('languages/available',[GlobalController::class,'languages']);
Route::get('image/{title}',[GlobalController::class,'getImage']);
Route::post('otp/generate',[GlobalController::class,'generateOtp']);

Route::group(['middleware'=>['auth:vendor,customer,admin']],function(){
    Route::get('countries/available',[GlobalController::class,'getCountries']);
    Route::get('banks/available',[GlobalController::class,'getBanks']);
    Route::get('settings/invoice/type',[GlobalController::class,'getInvoiceSettingsType']);
    Route::get('locations',[GlobalController::class,'getLocations']);
});


Route::group(['prefix'=>'customers'],function(){
    Route::group(['prefix'=>'auth'],function(){
        Route::post('registration',[AuthController::class,'registration'])->middleware('guest:customer');
        Route::post('login',[AuthController::class,'login'])->middleware('guest:customer');
        Route::group(['middleware'=>['auth:customer']],function(){
            Route::get('me',[AuthController::class,'me']);
            Route::post('logout',[AuthController::class,'logout']);
        });
    });
});


