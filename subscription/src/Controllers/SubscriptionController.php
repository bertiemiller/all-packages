<?php

namespace Topicmine\Subscription\Controllers;

use Topicmine\DataTables\Controllers\DataTablesController;
use Topicmine\Subscription\Requests\SubscriptionRequest;
use Topicmine\Subscription\Repositories\SubscriptionRepositoryInterface;

class SubscriptionController extends DataTablesController
{
    public $modelOwner = 'App\Account';
    public $modelRelation = 'card';

    public function __construct(SubscriptionRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }
    
    public function create()
    {
        $this->useStaticView = true;

        $data['address'] = auth_user()->contacts()->where('default', 1)->first();

        $plans = repo()->make('Topicmine\Subscription\Repositories\Plan');
        $data['topics'] = $plans->getTopicPlanOptions();
        $data['domains'] = $plans->getDomainPlanOptions();

        $data['formAction'] = route('topicmine.subscription.subscription.store');

        return view('admin.panels.subscription.create', compact(['data']));
    }

    public function store(SubscriptionRequest $request)
    {
        $inputs = $request->all();

        if (! isset($inputs['stripeToken'])
            && ! ( $inputs['topics'] == 10 && $inputs['domains'] == 1 )
        ){
            return redirect()->back();
        }

        $this->repo->create($inputs);

        flash('Subscription successful!', 'success');
        return redirect()->route('topicmine.subscription.subscription.index');
    }

    public function edit($id)
    {
        $plans = repo()->make('Topicmine\Subscription\Repositories\Plan');
        $plan = $plans->getPlanFromSubscriptionId($id);

        if(false === $plan) {
            flash('You are currently on a free trial. Please upgrade to a new subscription.');
            return redirect()->route('topicmine.subscription.subscription.create');
        }

        $data['subscribedTo'] = false;
        if (account_user()->subscribed(config('admin.stripe_plan_name'))) {
            $data['subscribedTo'] = config('admin.stripe_plan_name');
        }

        $data['address'] = auth_user()->contacts()->where('default', 1)->first();

        $data['topics'] = $plans->getTopicPlanOptions();
        $data['domains']= $plans->getDomainPlanOptions();

        // add current plan
        $data['topics']['value'] = $plan['topics'];
        $data['domains']['value'] = $plan['domains'];

        $data['subscriptionId'] = $id;
        if(account_user()->subscription('main')->cancelled()) {
            view()->share( 'dataButtons', 'resumeSubscription' );
        }

        view()->share( 'data', $data );
        return view('admin.panels.subscription.create');
    }

    public function update($id, SubscriptionRequest $request)
    {
        $this->repo->update($request->all(), $id);

        flash('Subscriptions successfully updated.', 'success');
        return redirect()->route('topicmine.subscription.subscription.index');
    }

    public function destroy($id)
    {
        $this->repo->destroy($id);

        flash('Subscriptions successfully cancelled.', 'success');
        return redirect()->route('topicmine.subscription.subscription.index');
    }
    
}