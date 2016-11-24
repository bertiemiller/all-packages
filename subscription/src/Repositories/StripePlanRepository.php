<?php

namespace Topicmine\Subscription\Repositories;

use Topicmine\Subscription\Models\Account;
use Topicmine\Subscription\Models\StripePlan;
use Topicmine\Core\Repositories\CoreRepository;

class StripePlanRepository extends CoreRepository implements StripePlanRepositoryInterface {

    public function model()
    {
        return StripePlan::class;
    }

    public function getPlanAttributes($stripe_id, $name, $amount, $trial_period_days, $description, $type)
    {
        return $this->model->getPlanAttributes($stripe_id, $name, $amount, $trial_period_days, $description, $type);
    }

}