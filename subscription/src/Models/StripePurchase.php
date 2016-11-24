<?php

namespace Topicmine\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

class StripePurchase extends Model
{
    public $fillable = [
        'id',
        'name',
        'currency',
        'amount_due',
        'trial_period_days',
        'interval',
        'interval_count',
        'statement_descriptor',
    ];
}
