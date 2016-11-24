<?php

namespace Topicmine\Subscription\Repositories;

use Carbon\Carbon;

trait BillingProfile
{

    private function transform($onetime_purchase)
    {
        $transformed = [];
        foreach($onetime_purchase->data as $key => $value)
        {
            $value = $value->__toArray();

            if($value['description'] == 'Non Subscription DevelopersHangout Sponsor Slot')
            {
                $value['created']   = Carbon::createFromTimestamp($value['created']);
                $value['amount']    = money_format('$%i', $value['amount'] / 100);
                $value['status']    = ucfirst($value['status']);

                $transformed[] = $value;
            }
        }

        return $transformed;
    }
    
}