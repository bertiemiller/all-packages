<?php

namespace Topicmine\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

class StripePlan extends Model {
    
    public $fillable = [
        'id',
        'name',
        'currency',
        'amount',
        'trial_period_days',
        'interval',
        'interval_count',
        'statement_descriptor',
    ];

    public function getPlanAttributes($stripe_id, $name, $amount, $trial_period_days, $description, $type)
    {
        return [
            'id'                   => $stripe_id,
            'name'                 => $name,
            'amount'               => $amount,
            'trial_period_days'    => $trial_period_days,
            'currency'             => 'gbp',
            'interval'             => 'month',
            'interval_count'       => 1,
            'statement_descriptor' => $description,
            'metadata'             => [
                'type' => $type,
            ]
        ];
    }
    
}