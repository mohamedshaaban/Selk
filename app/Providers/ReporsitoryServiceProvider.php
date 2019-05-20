<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ReporsitoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Http\Interfaces\SlidersRepostoryInterface',
            'App\Http\Eloquent\SlidersRepostory'


        );
    }
}
