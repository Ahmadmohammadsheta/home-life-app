<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // to use the filter in the same request validation syntax => 'name'=> 'required|filter' // AMA custom
        Validator::extend('filter', function($attribute, $value, $params){
            return in_array($value, $params);
        }, "The value is prohibted");

        // to make the table pagination using bootstrap css becausee the default using tailwind
        Paginator::useBootstrapFive();
        // Paginator::defaultView('crud.pagination.custom');
    }
}
