<?php

namespace SergioBogatsky\TelegramPollsWithoutGroup;

use App\Poll;
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
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes');
        $this->loadViewsFrom(__DIR__.'/views', 'SergioBogatsky\TelegramPollsWithoutGroup');

        if ($this->app->runningInConsole()) {
            $this->commands([
                'php artisan migrate'
            ]);
        }
    }

}
