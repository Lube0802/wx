<?php

namespace App\Providers;

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
        $this->app->singleton('Helper', function () {
            return new \App\Lib\Helper();
        });

        $this->app->singleton('AuthUser', function () {
            return new \App\Lib\AuthUser();
        });

        $this->app->singleton('Wechat', function() {
            return new \EasyWeChat\Foundation\Application(config('wechat'));
        });
    }
}
