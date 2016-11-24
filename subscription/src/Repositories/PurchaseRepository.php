<?php

namespace Topicmine\Subscription\Repositories;

use Illuminate\Pagination\Paginator;
use Topicmine\Subscription\Models\Purchase;
use Topicmine\Core\Repositories\CoreRepository;
use Topicmine\Subscription\Transformers\PurchaseTransformer;

class PurchaseRepository extends CoreRepository implements PurchaseRepositoryInterface
{
    public function model()
    {
        return Purchase::class;
    }

    public function transformer()
    {
        return PurchaseTransformer::class;
    }

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        $invoices = [];
        if (account_user()->subscribed(config('subscription.stripe_plan_name'))) {
//            $invoices = account_user()->invoices();
            $invoices = account_user()->invoicesIncludingPending();

            // Paginate for use with datatables
            $inputs = request()->all();

            if(isset($inputs['per_page'])) {
                $perPage = $inputs['per_page'];
            } else {
                $perPage = config('repository.pagination.limit', 15) ;
            }

            if(isset($inputs['page'])) {
                $page = $inputs['page'];
            } else {
                $page = 1 ;
            }

            $invoices = new Paginator($invoices, $perPage, $page);
        }

        return $invoices;
    }
    
    public function printInvoice($id)
    {
        return account_user()->downloadInvoice($id, [
            'vendor'  => 'Your Company',
            'product' => 'Your Product',
        ]);
    }
}