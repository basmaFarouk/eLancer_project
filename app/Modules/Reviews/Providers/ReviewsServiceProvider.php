<?php

namespace App\Modules\Reviews\Providers;

use Illuminate\Support\ServiceProvider;

class ReviewsServiceProvider extends ServiceProvider{
    public function register(){

    }

    public function boot(){
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views','reviews');
        $this->loadJsonTranslationsFrom(__DIR__.'/../lang');
        $this->mergeConfigFrom(__DIR__.'/../config/reviews.php','reviews');

        $this->publishes([
            __DIR__.'/../config/reviews.php' => config_path('reviews.php'),
        ],'config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/reviews'),
        ],'views');
    }
}
