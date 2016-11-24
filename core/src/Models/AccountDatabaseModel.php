<?php

namespace Topicmine\Core\Models\Account;

use Auth;
use Illuminate\Database\Eloquent\Model;

/*
 * This class automatically sets the database to the correct account
 * connection
 */

abstract class AccountDatabaseModel extends Model
{
    public $dates = ['created_at', 'updated_at'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        // This feature is for the admin section which requires authorisation
        if(auth()->check()) {

            // Set the database connection name.
            $this->upgradeConnection(account());
        }
    }

    public function upgradeConnection($account)
    {
        // The account model has a trait which sets the database connection
        $this->connection = $account->userDatabaseConnectionKey();

        // This is the default Eloquent Model connection method
        $this->setConnection($this->connection);
    }
}
