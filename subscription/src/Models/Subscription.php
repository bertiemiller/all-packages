<?php

namespace Topicmine\Subscription\Models;

use Illuminate\Database\Eloquent\Model;
use Topicmine\Subscription\Models\Plan;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $connection = 'mysql';

    protected $fillable = [
        'id',
        'name',
        'stripe_plan',
        'trial_ends_at',
        'ends_at',
        'created_at',
        'update_at',
    ];

    public $dates = ['trial_ends_at'];

    public function plans()
    {
        return Plan::where('stripe_id', $this->stripe_plan);
    }
}
