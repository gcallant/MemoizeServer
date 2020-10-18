<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
//        Passport::hashClientSecrets();
//
//        Passport::personalAccessClient(config('passport.personal_access_client.id'));
//        Passport::personalAccessClientSecret(config('passport.personal_access_client.secret'));
    }
}
