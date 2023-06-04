<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $this->resgisterMacros();
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('global')
                ->group(base_path('routes/api.php'));

            Route::prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::prefix('vendors')
                ->group(base_path('routes/vendor.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }


     /**
     * Register macros to add additional fatures.
     *
     * @return void
     */
    protected function resgisterMacros(){
        Route::macro('additionalroutes', function($name, $controller,$options=[] ){

            $singular = Str::singular($name);
            $except = Arr::get($options,'except',[]);
            $softdelete = Arr::get($options,'softdelete',false);
            if($softdelete){
                if(! Arr::has($except,'destroyMultiple')){
                    Route::put('/'.$name.'/multiple/destroy',[$controller,'destroyMultiple'])->name($name.'.destroyMultiple');
                }
                if(! Arr::has($except,'forcedelete')){
                    Route::delete('/'.$name.'/{'. $singular.'}/destroy/force',[$controller,'forceDelete'])->name($name.'.forcedelete');
                }
                if(! Arr::has($except,'restore')){
                    Route::put('/'.$name.'/{'. $singular.'}/restore',[$controller,'restore'])->name($name.'.restore');
                }
                if(! Arr::has($except,'restoreall')){
                    Route::put('/'.$name.'/trash/restore/all',[$controller,'restoreAll'])->name($name.'.restoreall');
                }
                if(! Arr::has($except,'emptyTrash')){
                    Route::delete('/'.$name.'/trash/clear',[$controller,'emptyTrash'])->name($name.'.emptyTrash');
                }
            }
        });
    }

}
