<?php

namespace App\Providers;

use App\Models\Config as ConfigModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use NumberFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //include __DIR__ . '/../helpers.php';

        //بحطها جوا السيرفس بروفايدر
        $this->app->bind('currency',function($app){
            return new NumberFormatter(App::currentLocale(),NumberFormatter::CURRENCY);
        });
        $frmt=new NumberFormatter(App::currentLocale(),NumberFormatter::CURRENCY);
        $this->app->instance('curreny',$frmt); //بديها الاسم والاوبجيكت
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $configs=Cache::get('configs');
        if(!$configs){
            $configs=ConfigModel::all();
            Cache::put('configs',$configs);
        }
        // foreach(ConfigModel::all() as $config){
        foreach($configs as $config){

            Config::set($config->name,$config->value);
        }

        App::setLocale(request('lang','en'));
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
