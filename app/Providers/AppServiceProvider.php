<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Api\v1\User\UserService;
use App\Interface\Api\v1\User\UserServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
