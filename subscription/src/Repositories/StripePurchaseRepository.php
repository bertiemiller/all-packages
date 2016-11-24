<?php
namespace Topicmine\Subscription\Repositories;

use Topicmine\Subscription\Models\StripePurchase;
use DB;
use Stripe;
use App\Exceptions\GeneralException;
use Topicmine\Core\Repositories\CoreRepository;

class StripePurchaseRepository extends CoreRepository implements StripePurchaseRepositoryInterface{

    public function model()
    {
        return StripePurchase::class;
    }
    
    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        /*
         * customer
         * date
         * ending_before
         * limit
         * starting_after
         */

        try
        {
            $invoices = Stripe::invoices()->all(['limit' => config('repository.pagination.limit', 15)]);
        }
        catch (NotFoundException $e)
        {
            throw new GeneralException('There was a problem connecting to the payment server. 
            Please try again in a few minutes.');
        }

        $rows['data'] = $this->getAllowedFields($this->modelBase->getFillable(), $invoices['data']);

        /*
         * Look at create a new paginator object
         */
        return $this->model->hydrate($rows)->toArray();
    }
    
    public function printInvoice($id)
    {
        return auth_user()->downloadInvoice($id, [
            'vendor'  => 'Your Company',
            'product' => 'Your Product',
        ]);
    }

}