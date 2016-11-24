<?php

namespace Topicmine\Core\Models\Account;

use App\User;
use Topicmine\Core\Models\Account\Domain;
use Topicmine\Core\Models\Account\Database;

trait AccountRelationships {

    public function database()
    {
        return $this->hasOne(Database::class, 'id', 'database_id');
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function admins()
    {
        return User::join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', 2);
    }

    public function card()
    {
        return User::select('id', 'stripe_id', 'card_brand', 'card_last_four')
            ->where( 'id', $this->user_id );
    }
}