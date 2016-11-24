<?php

namespace Topicmine\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model
{
    protected $table = 'cancellations';

    protected $connection = 'mysql';

    public $fillable = [
        'reason',
        'rating',
        'user_id',
        'account_id',
        'subscription_id',
    ];
    
    public $reasonOptions = [
        'project__research_finished'   => 'Your project research has finished',
        'too_expensive'   => 'Too expensive',
        'too_difficult'   => 'Too difficult to use',
        'business_reasons'   => 'Other business reasons',
        'other'   => 'Other',
    ];

    public $ratingOptions = [
        'very_poor'   => 'Very poor',
        'poor'   => 'Poor',
        'as_expected'   => 'As expected',
        'good'   => 'Good',
        'very_good'   => 'Very good',
    ];

    public $updateFields = [
        'reason' => [
            'name' => 'reason',
            'type' => 'select',
            'value' => 'too_expensive',
        ],
        'rating' => [
            'name' => 'rating',
            'type' => 'select',
        ]
    ];

}
