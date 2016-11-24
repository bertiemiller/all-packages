<?php

namespace Topicmine\Subscription\Middleware;

use App\Account;
use Request;
use Auth;
use Closure;

class SubscriptionSetup {

    protected $settingUp = false;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $account = $user->account()->first();

        // account user owner (not neccessarily this user)
        // it's the user_id in the account table
        $account_user = $account->user();

        // need to do : if account is deactivated, redirect them through
        // subscription with a welcome back message

        if ($this->accountNotScubcribed($user, $account_user, $account))
            return redirect()->route('topicmine.subscription.subscription.create');

        return $next($request);
    }

    public function accountNotScubcribed($user, $account_user, $account)
    {
        if (
            ! $user->hasRole('SuperUser') &&
            ! $account_user->subscribed(config('subscription.stripe_plan_name')) &&
            ! $account_user->onTrial()
        )
        {
            $allowedSubscriptionRoutes = ['topicmine.subscription.subscription.create', 'topicmine.subscription.subscription.store'];
            if (!array_intersect($allowedSubscriptionRoutes, [route_name()]) && $this->settingUp == false)
            {
                return true;
            }
            else
            {
                $this->settingUp = true;
            }
        }

        return false;
    }

}
