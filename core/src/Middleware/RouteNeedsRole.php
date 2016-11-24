<?php

namespace Topicmine\Core\Middleware;

use Closure;

class RouteNeedsRole
{
    public function handle($request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role)) {
            flash('General error - role-notallowed-> ' . $role, 'danger');
            return redirect('/?needs-role');
        }

        return $next($request);
    }
}