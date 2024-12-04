<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use App\Broadcasting\PusherBeamsChannel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        $this->app->extend(ChannelManager::class, function ($manager) {
            $manager->extend('pusher_beams', function () {
                return new PusherBeamsChannel();
            });

            return $manager;
        });

    }
}
