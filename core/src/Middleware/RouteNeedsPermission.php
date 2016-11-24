<?php

namespace Topicmine\Core\Middleware;

use Closure;

class RouteNeedsPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (! $request->user()->isAllowedTo($permission)) {
            flash(' General error - permission-notallowed -> ' . $permission, 'danger');
            return redirect('/?RouteNeedsPermission');
        }

        return $next($request);
    }
}
