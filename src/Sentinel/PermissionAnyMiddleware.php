<?php



declare(strict_types=1);

namespace BrianFaust\Middlewares\Sentinel;

use Closure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PermissionAnyMiddleware
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

        if (!$request->user()->hasAnyAccess($permission)) {
            throw new AccessDeniedHttpException(trans('auth.errors.invalid_permission'));
        }

        return $next($request);
    }
}
