<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UsersController;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Route;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
//        Model::shouldBeStrict( ! $this->app->isProduction());
        if (true === config('app.force_https')) {
            URL::forceScheme('https');
        }


        Scramble::extendOpenApi(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
            );
        });

        Route::macro('route', function (string $baseUrl = ''): void {
            Route::prefix($baseUrl)->group(function (): void {
                Route::middleware('throttle:5,10')->post('login', [AuthController::class, 'login']);

                Route::group(['middleware' => ['auth:api']], routes: static function (): void {
                    Route::post('logout', action: [AuthController::class, 'logout']);
                });


                Route::apiResource('users', UsersController::class)->only('show', 'index');
                Route::get('articles', [ArticleController::class, 'index']);
                Route::get('articles/{article}', [ArticleController::class, 'show']);
            });
        });
    }
}
