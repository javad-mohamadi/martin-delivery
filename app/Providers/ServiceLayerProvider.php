<?php

namespace App\Providers;

use App\Services\AuthenticationService;
use App\Services\CompanyOrderService;
use App\Services\CourierOrderService;
use App\Services\Interfaces\AuthenticationServiceInterface;
use App\Services\Interfaces\CompanyOrderServiceInterface;
use App\Services\Interfaces\CourierOrderServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServiceLayerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->bind(CompanyOrderServiceInterface::class, CompanyOrderService::class);
        $this->app->bind(CourierOrderServiceInterface::class, CourierOrderService::class);
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
