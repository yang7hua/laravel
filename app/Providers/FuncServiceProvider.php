<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FuncServiceProvider extends ServiceProvider
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
		$this->app->singleton('func', function($app){
			return new \App\Lib\Func();	
		});
    }
}
