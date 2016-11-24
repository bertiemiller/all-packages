<?php

namespace Topicmine\Core\Repositories\Account;

use App\Account;
use Topicmine\Core\Repositories\CoreRepository;

class AccountRepository extends CoreRepository implements AccountRepositoryInterface {

    public function model()
    {
        return Account::class;
    }
}