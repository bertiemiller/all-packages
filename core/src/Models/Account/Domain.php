<?php

namespace Topicmine\Core\Models\Account;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $table = 'domains';

    protected $connection = 'mysql';

    public $fillable = [
        'name',
        'url',
        'account_id',
    ];

    public $updateFields = [
        'name',
        'url',
    ];
    
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
