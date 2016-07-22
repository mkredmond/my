<?php

namespace App\Auth;

use App\Auth\LdapUserProvider;
use Auth;
use Illuminate\Support\ServiceProvider;

class LdapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::provider('sjfc', function ($app, array $config) {
            return new LdapUserProvider($this->app['hash'], $config['model']);
        });
    }

    public function register()
    {
    }
}
