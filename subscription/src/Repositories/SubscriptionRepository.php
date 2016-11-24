<?php

namespace Topicmine\Subscription\Repositories;

use Stripe;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Topicmine\Core\Models\User\Contact;
use Illuminate\Pagination\LengthAwarePaginator;
use Topicmine\Subscription\Models\Subscription;
use Topicmine\Core\Repositories\CoreRepository;
use Topicmine\Subscription\Repositories\BillingProfile;

class SubscriptionRepository extends CoreRepository implements SubscriptionRepositoryInterface {

    use BillingProfile;

    public function model()
    {
        return Subscription::class;
    }

    public function getPlanRepo()
    {
        if (isset($this->planRepo))
        {
            return $this->planRepo;
        }

        $this->planRepo = repo()->make('Topicmine\Subscription\Repositories\Plan');
        Stripe::setApiKey(env('STRIPE_SECRET'));

        return $this->planRepo;
    }

    public function getStripePlanRepo()
    {
        if (isset($this->stripePlanRepo))
        {
            return $this->stripePlanRepo;
        }

        $this->stripePlanRepo = repo()->make('Topicmine\Subscription\Repositories\StripePlan');
        Stripe::setApiKey(env('STRIPE_SECRET'));

        return $this->stripePlanRepo;
    }

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        $select = ['subscriptions.id',
            'plans.name',
            'plans.name',
            'plans.description',];

        $planRepo = $this->getPlanRepo();
        $args = $planRepo->getPlanArgs();

        foreach ($args as $key => $value)
        {
            array_push($select, 'plans.' . $value);
        }

        array_push($select,
            'plans.price',
            'subscriptions.ends_at',
            'subscriptions.created_at',
            'subscriptions.updated_at'
        );

        $collection = account_user()->subscriptions()
            ->where('subscriptions.name', config('subscription.stripe_plan_name'))
            ->join('plans', 'subscriptions.stripe_plan', '=', 'plans.stripe_id')
            ->select($select)->paginate($limit);

        if ($collection->isEmpty() && account_user()->onTrial())
        {
            $unit = collect([collect([
                'id'           => 1,
                'subscription' => 'Free Trial',
                'end_date'     => account_user()->trial_ends_at->toFormattedDateString(),
            ])]);

            $paginator = new LengthAwarePaginator($unit, $unit->count(), 10);

            return $paginator;
        }

        return $collection;
    }

    public function getPlan($args)
    {
        $planRepo = $this->getPlanRepo();

        return $planRepo->getPlanFromQuantities($args);
    }

    public function create(array $inputs)
    {
        if ($inputs['topics'] == 10 && $inputs['domains'] == 1)
        {
            return $this->createFreeTrial();
        }

        $planRepo = $this->getPlanRepo();
        $plan = $this->getPlan(array_intersect_key($inputs, array_flip($planRepo->getPlanArgs())));

        $token = $inputs['stripeToken'];
        if (!account_user()->subscribedToPlan($plan->stripe_id, config('subscription.stripe_plan_name')))
        {
            account_user()->newSubscription(config('subscription.stripe_plan_name'), $plan->stripe_id)
                ->create($token);
        }

        $addObj = new Contact; // user repository
        $contact = $addObj->where('user_id', auth_user()->id)->first();
        $contact->fill($inputs)->save();

        return false;
    }

    public function createFreeTrial()
    {
        $planRepo = $this->getPlanRepo();

        $user = account_user();
        $trialInfo['trial_ends_at'] = Carbon::now()->addDays($planRepo->getFreeTrialDays());
        $user->fill($trialInfo);
        $user->save();

        return $user->save();
    }

    public function update(array $inputs, $id)
    {
        if (isset($inputs['action_resume']))
        {
            $this->resumePlan();
        }

        $subscriptionCurrent = account_user()->subscriptions()
            ->where('name', config('subscription.stripe_plan_name'))->first()->toArray();

        $planNew = $this->getPlanRepo()->getPlanFromQuantities(
            array_intersect_key($inputs, array_flip($this->getPlanRepo()->getPlanArgs()))
        );

        // check both plans exist

        if ($subscriptionCurrent['stripe_plan'] != $planNew['stripe_id'])
        {
            account_user()->subscription(config('subscription.stripe_plan_name'))
                ->swap($planNew['stripe_id']);

//            event(new UserSubscriptionSwapped(auth()->user()));
        }

        return true;
    }

    public function resumePlan()
    {
        return account_user()->subscription(config('subscription.stripe_plan_name'))->resume();
    }

    public function cancelPlan()
    {
        return account_user()->subscription(config('subscription.stripe_plan_name'))->cancel();
    }

    public function delete($id)
    {
        $this->cancelPlan();
    }

}