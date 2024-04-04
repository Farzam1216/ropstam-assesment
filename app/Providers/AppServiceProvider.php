<?php

namespace App\Providers;

use App\Services\Car\CarInterface;
use App\Services\Car\CarService;
use App\Services\Category\categoryInterface;
use App\Services\Category\categoryService;
use App\Services\User\UserInterface;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(UserInterface::class, UserService::class);
        $this->app->bind(categoryInterface::class, categoryService::class);
        $this->app->bind(CarInterface::class, CarService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
