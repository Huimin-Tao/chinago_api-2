<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
    protected function configureRateLimiting()
{
    RateLimiter::for('api', function (Request $request) {
        // Ejemplo: 60 peticiones por minuto por usuario (o por IP si no hay usuario)
        return Limit::perMinute(60)->by(
            optional($request->user())->id ?: $request->ip()
        );
    });
}
}
