<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \App\Http\Middleware\MenuMiddleware::class,

    ];
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'before'               => \App\Http\Middleware\BeforeMiddleware::class,
        'sentinel.auth'        => \App\Http\Middleware\SentinelAuth::class,
        'sentinel.permission'  => \App\Http\Middleware\SentinelPermission::class,
        'localize'             => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'isAdmin'              => \App\Http\Middleware\isAdmin::class,
        // 'clearcache' => \App\Http\Middleware\ClearCache::class,
        // 'NavCart' => \App\Http\Middleware\NavCart::class,
        'SentinelUser'  => \App\Http\Middleware\SentinelUser::class,
        'SentinelAdmin' => \App\Http\Middleware\SentinelAdmin::class,
    ];
}
