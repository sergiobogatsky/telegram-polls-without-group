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
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        //routes
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        //views
        $this->loadViewsFrom(__DIR__.'/views', 'polls');//SergioBogatsky\TelegramPollsWithoutGroup
        //translations
        $this->loadTranslationsFrom(__DIR__.'/translations', 'polls');


        $this->publishes([
            //views from VUE
            __DIR__.'/public/js/polls.js' => public_path('js/polls.js'),
            //send messages via telegram
            __DIR__.'/Telegram.php' => base_path('Telegram.php'),
        ]);

        //commands to add tables to db
        if ($this->app->runningInConsole()) {
            Artisan::call('migrate');
            Artisan::call('vendor:publish --provider="SergioBogatsky\TelegramPollsWithoutGroup\TelegramPollsWithoutGroupServiceProvider"');
        }
    }

}
