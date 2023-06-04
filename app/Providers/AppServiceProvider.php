<?php

namespace App\Providers;

use App\Actions\DbTransaction;
use App\Actions\FileManager;
use App\Actions\Identifier;
use App\Services\LanguageService;
use Exception;
use Illuminate\Support\ServiceProvider;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register language service container
        $this->app->singleton(LanguageService::class, function (Application $app) {
            return new LanguageService();
        });

        // Register fileManager service container
        $this->app->singleton(FileManager::class, function (Application $app) {
        return new FileManager();
        });

        // Register DbTransaction service container
        $this->app->singleton(DbTransaction::class, function (Application $app) {
            return new DbTransaction();
            });

        // Register l
        
        $this->app->bind(Identifier::class, function (Application $app) {
            return new Identifier(1);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
