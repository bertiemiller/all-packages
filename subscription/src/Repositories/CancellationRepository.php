<?php
namespace Topicmine\Subscription\Repositories;

use App\Exceptions\GeneralException;
use Topicmine\Subscription\Models\Cancellation;
use Topicmine\Core\Repositories\CoreRepository;

class CancellationRepository extends CoreRepository implements CancellationRepositoryInterface {

    public function model()
    {
        return Cancellation::class;
    }
    
    public function destroy($id)
    {
        $account = $this->model->find($id);

        if( empty($account) ) {
            throw new GeneralException('You\'re account could not be found');
        }

        $inputs['status'] = 0;
        $account->fill($inputs);
        return $account->save();
    }

}