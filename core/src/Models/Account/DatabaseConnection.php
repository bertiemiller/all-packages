<?php
namespace Topicmine\Core\Models\Account;


use Topicmine\Core\Models\Account;

trait DatabaseConnection{

    public function userDatabaseConnectionKey()
    {
        $database = $this->database()->first();

        $db = new Database;

        // Could store this key - this would require updating to query database
        // table and merge functionality with next settings function
        $newAccountConnectionKey = $db->getNewAccountDatabaseConnectionKey($this->id);

        // create dynamic connection settings
        $newAccountConnectionSettings = $db->getConnectionSettings($database);

        // Set the connection on each request
        config(['database.connections.'.$newAccountConnectionKey => $newAccountConnectionSettings]);

        return $newAccountConnectionKey;
    }
}