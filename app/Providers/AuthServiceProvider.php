<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
       // User::class=>UserPolicy::class,
       // Category::class=>UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Gate::before(function($user,$ability){

            return true;
        });
        

        foreach(config('abilities') as $ability=>$label){

            //Gate::define('categories.view',function($user){
            Gate::define($ability,function($user) use($ability){   //nnneeeewwww
                return $user->hasAbility($ability);
                // foreach($user->roles ?? [] as $role){
                //     //if(in_array('categories.view',$role->abilities)){
                //     if(in_array($ability,$role->abilities)){
                //         return true;
                //     }
                // }

                // return true;
            });
        }
    }
}
