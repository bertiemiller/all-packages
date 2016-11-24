<?php

namespace Topicmine\Core\Repositories\Traits;

trait ApiHelper {

    /*
     * For Api
     */

    public function upgradeModelConnection($account)
    {
        if (// Check if any of the models are on the user database connection
            class_exists('\\Topicmine\\Core\\Account\\AccountDatabaseModel')
            // and if so check they are extending the class which sets the connection
            && is_subclass_of($this->modelBase, '\\Topicmine\\Core\\Account\\AccountDatabaseModel')
        ){
            // if so, call the function to set the right connection
            $this->modelBase->upgradeConnection($account);
        }
    }

    public function updateSelectedIds($inputs)
    {
        $selectedIds = $inputs['selectedIds'];
        $uncheckedSelectedIds = $inputs['uncheckedSelectedIds'];

        switch ($inputs['action'])
        {
            case 'delete':

                if (!empty($selectedIds))
                {
                    $this->modelBase->destroy($selectedIds);

                    return true;
                }
                break;
        }

        return true;
    }

    // Action buttons can be set in transformers
    public function action($inputs)
    {
        return $this->{$inputs['action']}($inputs);
    }

}