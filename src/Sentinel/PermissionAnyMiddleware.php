<?php


declare(strict_types=1);

/*
 * This file is part of Laravel Middlewares.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
