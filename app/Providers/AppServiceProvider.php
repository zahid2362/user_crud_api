<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Api\v1\{User\UserService,Auth\AuthService};
use App\Interface\Api\v1\{Auth\AuthServiceInterface,User\UserServiceInterface};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
