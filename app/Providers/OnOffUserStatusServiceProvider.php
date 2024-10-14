<?php

namespace App\Providers;

use App\Models\User;
// use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class OnOffUserStatusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        view()->composer('*', function($view){

            $onlineusers = User::onlineusers(); 

            $view->with([
                'onlineusers' => $onlineusers
            ]);

        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}


// php artisan make:provider OnOffUserStatusServiceProvider