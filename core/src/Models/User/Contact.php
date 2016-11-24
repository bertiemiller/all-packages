<?php

namespace Topicmine\Core\Models\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $connection = 'mysql';
    
    public $fillable = [
//        'name',
        'first_name',
        'last_name',
        'billing_name',
        'address1',
        'address2',
        'address3',
        'town',
        'county',
        'postcode',
        'country',
        'organisation_name',
        'longitude',
        'latitude',
        'tel',
        'job_title',
//        'updated_at',
//        'created_at',
        'user_id',
    ];

    public $updateFields = [
        'first_name',
        'last_name',
    ];

    public $jobTitleOptions = [
        'assistant'   => 'Assistant',
        'manager'   => 'Manager',
        'director'   => 'Director',
        'head_of_department'   => 'Head of Department',
        'managing_director'   => 'Managing Director',
        'board_member'   => 'Board Director',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
