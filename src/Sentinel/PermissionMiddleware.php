<?php

/*
 * This file is part of Laravel Middlewares.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
        if (! is_array($permission)) {
            $permission = [$permission];
        }

        if (! $request->user()->hasAccess($permission)) {
            throw new AccessDeniedHttpException(trans('auth.errors.invalid_permission'));
        }

        return $next($request);
    }
}
