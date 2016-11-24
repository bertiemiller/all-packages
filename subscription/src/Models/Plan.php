<?php

namespace Topicmine\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model {
    
    protected $table = 'plans';

    protected $connection = 'mysql';
    
    public $fillable = [
        'stripe_id',
        'name',
        'description',
        'topics',
        'domains',
        'competitors',
        'ranks',
        'price',
        'expires',
    ];

    public $topicsMonthlyPrices = [
        10   => 0,
        50   => 500,
        200  => 2000,
        500  => 5000,
        1000 => 10000,
        5000 => 50000,
    ];

    public $domainsMonthlyPrices = [
        1  => 0,
        3  => 300,
        5  => 500,
        10 => 1000,
        50 => 5000,
    ];

    public $planArgs = [
        'topics',
        'domains'
    ];
    
    public $freeTrialDays = 120;


    public function getPriceFromQuantities($args)
    {
        return number_format((
                $this->topicsMonthlyPrices[$args['topics']] +
                $this->domainsMonthlyPrices[$args['domains']] +
                null
            ) / 100, 2, '.', '');
    }

    public function getStripeIdFromQuantities($args)
    {
        return strtoupper(config('subscription.stripe_plan_name')).
        $args['topics'].'T'.$args['domains'].'D'.
            str_replace('.','',
                (string) $this->getPriceFromQuantities($args)
            ) . 'P' ;
    }

    public function getPlanDescription()
    {
        return 'TM ' . config('subscription.stripe_plan_name') . ' monthly plan';
    }

}
