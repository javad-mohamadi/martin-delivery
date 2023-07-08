<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware(['api', 'throttle:10,1'])
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api/v1')
                ->as('api.v1')
                ->middleware(['auth:api'])
                ->namespace(sprintf('%s\%s', $this->namespace, 'Api\V1'))
                ->group(base_path('routes/api-v1.php'));

            Route::prefix('api/v1')
                ->as('public.api.v1.')
                ->namespace(sprintf('%s\%s', $this->namespace, 'General'))
                ->group(base_path('routes/public-v1.php'));
        });
    }
}
