<?php

namespace Topicmine\Subscription\Middleware;

use Closure;

class RedirectIfNotSubscribed
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
        if ($request->user() && ! $request->user()->subscribed( config('admin.stripe_plan_name') )) {
            // This user is not a paying customer...
            return redirect('/?billing-sign-up=from-middleware-subscribed');
        }
        
        return $next($request);
    }
}
