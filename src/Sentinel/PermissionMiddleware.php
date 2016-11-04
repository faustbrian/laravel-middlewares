<?php

namespace BrianFaust\Middlewares\Sentinel;

use Closure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PermissionMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param $permission
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (!is_array($permission)) {
            $permission = [$permission];
        }

        if (!$request->user()->hasAccess($permission)) {
            throw new AccessDeniedHttpException(trans('auth.errors.invalid_permission'));
        }

        return $next($request);
    }
}
