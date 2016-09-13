<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JWTTryGetUserFromToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($token = $this->auth->setRequest($request)->getToken()) {
            try {
                $user = $this->auth->authenticate($token);
                if ($user) {
                    $this->events->fire('tymon.jwt.valid', $user);
                }
            } catch (TokenExpiredException $e) {
                // ignore
            } catch (JWTException $e) {
                // ignore
            }
        }
        return $next($request);
    }
}
