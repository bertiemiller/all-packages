<?php
namespace Topicmine\Subscription\Transformers;

//use App\Models\Data\Topic\Topic;
use League\Fractal\TransformerAbstract;

class PurchaseTransformer extends TransformerAbstract {

    public function transform($model)
    {
        return [
            'id'       => $model->id,
            'date'     => $model->date()->toFormattedDateString(),
            'total'    => $model->total(),
            'download' => "<a href=\"/admin/account/subscription/invoices/" . $model->id . "\">Download</a>",
        ];
    }
}
