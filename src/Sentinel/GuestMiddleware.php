<?php

namespace BrianFaust\Middlewares\Sentinel;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class GuestMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Sentinel::check()) {
            throw new AccessDeniedHttpException(trans('auth.errors.invalid_permission'));
        }

        return $next($request);
    }
}
