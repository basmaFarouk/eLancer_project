<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //if(App::environment('production')) is equal to
        if(Config::get('app.env')=='production'){
            Config::set('app.debug'==false);
        }

        Validator::extend('filter',function($attribute,$value,$fail){
            if($value=='god'){
                return false;
            }
            return true;
        },'This Word is Invalid');

        Paginator::useBootstrap(); //use bootstrap instead of tailwind
        // Paginator::defaultView('vendor.pagination.tailwind'); //لو عاملة ملف خاص بيا فهديله الباث بتاعه
    }
}
