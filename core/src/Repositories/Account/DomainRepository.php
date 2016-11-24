<?php

namespace Topicmine\Core\Repositories\Account;

use Topicmine\Core\Models\Account\Domain;
use Topicmine\Core\Repositories\CoreRepository;

class DomainRepository extends CoreRepository implements DomainRepositoryInterface
{
    public function model()
    {
        return Domain::class;
    }

}