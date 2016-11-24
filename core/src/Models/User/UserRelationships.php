<?php

namespace Topicmine\Core\Models\User;

use Topicmine\Core\Models\Account\Domain;
use \Topicmine\Core\Models\User\Contact;

trait UserRelationships {

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}