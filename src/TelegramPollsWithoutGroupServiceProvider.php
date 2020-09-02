<?php

namespace SergioBogatsky\TelegramPollsWithoutGroup;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class TelegramPollsWithoutGroupServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->make(Poll::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //tables
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        //routes
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        //views
        $this->loadViewsFrom(__DIR__.'/views', 'polls');//SergioBogatsky\TelegramPollsWithoutGroup

        if ($this->app->runningInConsole()) {
            Artisan::call('migrate');
        }
    }

}
