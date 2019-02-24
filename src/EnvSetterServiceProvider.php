<?php

namespace Ahmed3lawady\EnvSetter;

use Illuminate\Support\ServiceProvider;

class EnvSetterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('command.env:set', EnvSetter::class);
        $this->commands([
            'command.env:set'
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
