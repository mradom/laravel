<?php

namespace App\Helpers;

use JWTAuth;
use JWTFactory;
use Illuminate\Http\Request;
use App\Exceptions\JWTException;

class JWTHelper
{
    protected $errors = [
        'token_absent'  => ['Token absent.',  400],
        'token_invalid' => ['Token invalid.', 400],
        'token_expired' => ['Token expired.', 401],
    ];

    /**
     * Generate JSON Web Token.
     */
    public function createToken($user)
    {
        return (string) JWTAuth::encode(
            JWTFactory::make(['sub' => $user->id])
        );
    }

    /**
     * Generate Json Web Token for Admins users
     */
    public function createAdminToken()
    {
        return (string) JWTAuth::encode(
            JWTFactory::make(['admin' => true])
        );
    }

    /**
     * Send JSON Web Token.
     */
    public function sendToken($user)
    {
        return response()->json(['token' => $this->createToken($user)]);
    }

    /**
     * Raise exception for the error key.
     */
    protected function throwError($key)
    {
        list($message, $code) = $this->errors[$key];

        throw new JWTException($message, $code);
    }

    /**
     * Get payload from request.
     */
    public function getPayloadFromRequest(Request $request)
    {
        $token = $this->getToken($request);
        $payload = $this->getPayload($token);

        return $payload;
    }

    /**
     * Get token from request.
     */
    public function getToken(Request $request)
    {
        if (! $request->header('Authorization') &&
            ! $request->has('access_token')) {
            $this->throwError('token_absent');
        }

        if ($request->header('Authorization')) {
            try {
                return explode(' ', $request->header('Authorization'))[1];
            } catch (\ErrorException $e) {
                $this->throwError('token_invalid');
            }
        } else {
            return $request->input('access_token');
        }
    }

    /**
     * Get payload from token.
     */
    public function getPayload($token)
    {
        try {
            return JWTAuth::getPayload($token)->toArray();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $this->throwError('token_expired');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $this->throwError('token_invalid');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $this->throwError('token_absent');
        }
    }
}
