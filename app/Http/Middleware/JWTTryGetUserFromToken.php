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
            } catch (TokenExpiredException $e) {
                // ignore
            } catch (JWTException $e) {
                // ignore
            }
            if ($user) {
                $this->events->fire('tymon.jwt.valid', $user);
            }
        }

        return $next($request);
    }

    /**
     * Fire event and return the response.
     *
     * @param  string   $event
     * @param  string   $error
     * @param  int  $status
     * @param  array    $payload
     * @return mixed
     */
    protected function respond($event, $error, $status, $payload = [])
    {
        $response = $this->events->fire($event, $payload, true);

        $result = [
            'code'    => -1,
            'message' => trans('jwt.' . $error),
        ];
        return $response ?: $this->response->json($result, $status);
    }
}
