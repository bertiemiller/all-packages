<?php

namespace Topicmine\Core\Models;

use App\User;
use App\AccountRelationshipsHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Topicmine\Core\Models\Account\DatabaseConnection;

class AccountBase extends Model
{
    use SoftDeletes, AccountRelationshipsHelper;
    use DatabaseConnection;

    protected $table = 'accounts';

    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'description',
        'status',
        'updated_at',
        'created_at',
        'user_id',
        'database_id',
    ];

    public $updateFields = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function user()
    {
        return User::find( $this->user_id );
    }
}
