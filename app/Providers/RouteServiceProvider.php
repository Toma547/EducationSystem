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
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/user/articles'; // ユーザーログイン後はお知らせ一覧にする

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            
            // APIルート
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // ユーザー用ルート    
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // 管理者用ルート
            Route::middleware('web')
                ->prefix('admin')  // URLに/admin を付ける
                ->name('admin.')  // ルート名に admin. を付ける
                ->group(base_path('routes/admin.php'));   
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
