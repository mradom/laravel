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
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'jwt.verify' => \App\Http\Middleware\JWTVerify::class,
        'jwt.auth.admin' => \App\Http\Middleware\JWTAuthAdmin::class,
        'jwt.auth.user' => \App\Http\Middleware\JWTAuthUser::class,
    ];
}