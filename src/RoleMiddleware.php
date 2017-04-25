
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

namespace BrianFaust\Middlewares;

use Auth;
use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (auth()->guest()) {
            abort(403);
        }

        if (!$request->user()->hasAnyRole(explode('|', $role))) {
            abort(403);
        }

        if ($permission && !$request->user()->can($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
