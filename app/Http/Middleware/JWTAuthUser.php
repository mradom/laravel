<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Helpers\JWTHelper;

/**
 * Check if the token correspond to an admin or the 
 * owner of resource
 */
class JWTAuthUser
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

        if ((! array_key_exists('admin', $payload) || $payload['admin'] !== true) &&
            ($request->userId != $payload['sub'])) {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $input = $request->all();
        $input['is_admin'] = (isset($payload['admin']) && $payload['admin'] == true);
        $request->replace($input);

        return $next($request);
    }
}
