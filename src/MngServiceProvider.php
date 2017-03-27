<?php

namespace KS\Mng;

use Illuminate\Support\ServiceProvider;

class MngServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mng', function(){
          return new Mng(config('app.mng'));
        });
    }
}
