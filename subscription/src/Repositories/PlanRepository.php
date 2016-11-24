<?php

namespace Topicmine\Subscription\Repositories;

use DB;
use Stripe;
use Topicmine\Subscription\Models\Plan;
use Topicmine\Core\Repositories\CoreRepository;
use Cartalyst\Stripe\Exception\NotFoundException;

class PlanRepository extends CoreRepository implements PlanRepositoryInterface {
    
    public function model()
    {
        return Plan::class;
    }

    public function getPlanArgs()
    {
        return $this->model->planArgs;
    }
    
    public function getFreeTrialDays()
    {
        return $this->model->freeTrialDays;
    }
    
    public function getPlanFromSubscriptionId($id)
    {
        $stripe_subscription =  DB::table('subscriptions')->find($id);

        if( empty($stripe_subscription) ) {
            return false;
        }
        
        return $this->model->where('stripe_id', $stripe_subscription->stripe_plan)->first();
    }

    public function getPlanFromQuantities($args)
    {
        return $this->findOrCreatePlanFromQuantities($args);
    }

    public function findOrCreatePlanFromQuantities($args)
    {
        $plan = $this->findPlanFromQuantities($args);

        if( null == $plan ) {
            $plan = $this->createStripePlanFromPlan($args);
        }

        return $plan;
    }

    public function findPlanFromQuantities($args)
    {
        $model = $this->model;
        $query = $model::select();

        foreach($args as $key=>$value) {
            $query->where($key, $value);
        }

        return $query->first();
    }
    
    public function createStripePlanFromPlan($args)
    {
        $plan = $this->createPlanFromQuantities($args);

        // need to handle timeout errors where Plan is created but StripePlan isn't
        // Turn StripePlan into PlanPayment

        try
        {
            Stripe::plans()->find($plan->stripe_id);
        }
        catch (NotFoundException $e)
        {
            $stripePlan = $this->getStripePlanFromPlan($plan);

            $response = $this->createStripePlan($plan, $stripePlan);

            if(false == $response) {
                flash('There was an error connecting with your subscription 
                    service. Please try again.', 'error');
                return redirect()->route('topicmine.admin.account.subscription.index');
            }
        }

        return $plan;
    }

    public function createStripePlan($plan, $stripePlan)
    {
        try
        {
            Stripe::plans()->create($stripePlan);
        }
        catch (InvalidRequestException $e)
        {
            $this->destroy($plan->id);
            return false;
        }
        return true;
    }

    public function createPlanFromQuantities($args)
    {
        $plan = $args;

        $plan['price'] = $this->model->getPriceFromQuantities($args);
        $plan['stripe_id'] = $this->model->getStripeIdFromQuantities($args);
        $plan['name'] = $plan['stripe_id'];
        $plan['description'] = $this->model->getPlanDescription($args); 
        
        return $this->model->create($plan);
    }

    public function getStripePlanFromPlan($plan)
    {
        $stripe_id = $plan['stripe_id'];
        $name = $plan['name'];
        $amount = $plan['price'];
        $trial_period_days = $plan['trial_period_days'];
        $description = $plan['description'];
        $type = config('admin.stripe_plan_name');

        return  $this->getStripePlanRepo()
            ->getPlanAttributes($stripe_id, $name, $amount, $trial_period_days, $description, $type);
    }

    public function getTopicPlanOptions()
    {
        $prices = $this->model->topicsMonthlyPrices;
        $planArg['options'] = $this->getPlanOptions('topics', $prices);
        $planArg['value'] = null;
        return $planArg;
    }

    public function getDomainPlanOptions()
    {
        $prices = $this->model->domainsMonthlyPrices;
        $planArg['options'] = $this->getPlanOptions('domains', $prices);
        $planArg['value'] = null;
        return $planArg;
    }

    public function getPlanOptions($type, $prices)
    {
        array_walk($prices, function(&$value, $key) use($type) {
            if($value == 0) {
                $value = $key . ' ' . str_singular($type) . ' FREE';
            } else {
                $value = $key . ' ' . $type . ' £' . $value/100;
            }
            $key = $key . $type;
        });
        return $prices;
    }

    public function getStripePlanRepo()
    {
        if( isset( $this->stripePlanRepo) ) {
            return $this->stripePlanRepo;
        }

        $this->stripePlanRepo = repo()->make('Topicmine\Admin\Repositories\StripePlan');

        Stripe::setApiKey(env('STRIPE_SECRET'));

        return $this->stripePlanRepo;
    }
    
}