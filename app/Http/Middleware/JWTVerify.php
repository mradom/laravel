<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Helpers\JWTHelper;

/**
 * Check that the token is valid
 */
class JWTVerify
{
    /**
     * The Guard implementation.
     *
     * @var JWTHelper
     */
    protected $jwtHelper;

    /**
     * Create a new verifier instance.
     *
     * @param JWTHelper jwtHelper
     */
    public function __construct(JWTHelper $jwtHelper)
    {
        $this->jwtHelper = $jwtHelper;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $payload = $this->jwtHelper->getPayloadFromRequest($request);
        } catch (\App\Exceptions\JWTException $e) {
            return response()->json(
                ['error' => $e->getMessage()], $e->getCode()
            );
        }

        return $next($request);
    }
}
