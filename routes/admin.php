<?php

use App\Http\Controllers\Api\V1\AccountTypeController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\AuthorizationController;
use App\Http\Controllers\Api\V1\BankAccountController;
use App\Http\Controllers\Api\V1\BankController;
use App\Http\Controllers\Api\V1\ChequeBookController;
use App\Http\Controllers\Api\V1\Global\GlobalController;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SliderController;
use App\Http\Controllers\Api\V1\SocialMediaController;
use App\Http\Controllers\Api\V1\LogoController;
use App\Http\Controllers\Api\V1\ChequeNumberController;


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

//Authentication
Route::group(['prefix' => 'auth'], function () {
   Route::post('login', [AuthController::class, 'adminLogin'])->middleware('guest:admin');
   Route::group(['middleware' => ['auth:admin']], function () {
      Route::get('me', [AuthController::class, 'me']);
      Route::post('logout', [AuthController::class, 'logout']);
   });
});

Route::group(["middleware"=>'auth:admin'],function(){
    //commons

    Route::group(['prefix'=>'global'],function(){
        Route::get('status',[GlobalController::class,'getAdminStatus']);
        Route::get('/vendor/status',[GlobalController::class,'getVendorStatus']);
    });

    Route::group(["prefix"=>"authorization", ],function(){
        Route::resource('roles',AuthorizationController::class);
        Route::additionalroutes('roles',AuthorizationController::class,['softdelete'=>Service::authorization()->hasSoftdelete()]);
        Route::get('modules/select',[AuthorizationController::class,'getModulesForSelect']);
        Route::get('roles/for/select',[AuthorizationController::class,'getRolesForSelect']);
    });

    // Admins
    Route::group(['middleware'=>'auth:admin'],function(){
      Route::get('status/get',[AdminController::class,'getStatus']);
      Route::put('/admins/status/update/{admin}',[AdminController::class,'statusUpdate']);
      Route::resource('admins',AdminController::class);
      Route::additionalroutes('admins',AdminController::class,['softdelete'=>Service::admin()->hasSoftdelete()]);
    });




   //cms
   Route::group(['prefix' => 'cms'], function () {

      // sliders
      Route::resource('sliders', SliderController::class);
      Route::put('/sliders/status/update/{id}',[SliderController::class,'statusUpdate']);
      Route::additionalroutes('sliders', SliderController::class, ['softdelete' => Service::slider()->hasSoftdelete()]);
      

      // logos
      Route::resource('logos', LogoController::class);
      Route::put('/logos/status/update/{id}',[LogoController::class,'statusUpdate']);
      Route::additionalroutes('logos', LogoController::class, ['softdelete' => Service::logo()->hasSoftdelete()]);

      // social media
      Route::resource('socialMedia', SocialMediaController::class);
      Route::put('/socialMedia/status/update/{id}',[SocialMediaController::class,'statusUpdate']);
      Route::additionalroutes('socialMedia', SocialMediaController::class, ['softdelete' => Service::socialMedia()->hasSoftdelete()]);
      


    });


   Route::group(['prefix' => 'accounts', 'middleware' => 'auth:admin'], function () {
      // account type
      Route::resource('accountTypes', AccountTypeController::class);
      Route::additionalroutes('accountTypes', AccountTypeController::class, ['softdelete' => Service::accountType()->repository->hasSoftdelete()]);

      //bank
      Route::resource('banks', BankController::class);
      Route::put('/banks/status/update/{id}',[BankController::class,'statusUpdate']);
      Route::additionalroutes('banks', BankController::class, ['softdelete' => Service::bank()->repository->hasSoftdelete()]);

      //bank account
      Route::resource('bankAccounts', BankAccountController::class);
      Route::put('/bankAccounts/status/update/{id}',[BankAccountController::class,'statusUpdate']);
      Route::put('/bankAccounts/deposit/{id}',[BankAccountController::class,'deposit']);
      Route::additionalroutes('bankAccounts', BankAccountController::class, ['softdelete' => Service::bankAccount()->repository->hasSoftdelete()]);
      
      //cheque book
      Route::resource('chequeBooks', ChequeBookController::class);
      Route::put('/chequeBooks/status/update/{id}',[ChequeBookController::class,'statusUpdate']);
      Route::additionalroutes('chequeBooks', ChequeBookController::class, ['softdelete' => Service::chequeBook()->repository->hasSoftdelete()]);
      
      //cheque number
      Route::resource('chequeNumbers', ChequeNumberController::class);
      Route::put('/chequeNumbers/status/update/{id}',[ChequeNumberController::class,'statusUpdate']);
      Route::additionalroutes('chequeNumbers', ChequeNumberController::class, ['softdelete' => Service::chequeNumber()->repository->hasSoftdelete()]);

   });

});
