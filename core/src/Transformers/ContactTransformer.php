<?php
namespace Topicmine\Core\Transformers;

use League\Fractal\TransformerAbstract;

class ContactTransformer extends TransformerAbstract {

    public function transform($model)
    {
        return [
            'id'       => $model->id,
            'first_name'     => $model->first_name,
            'last_name'     => $model->last_name,
            'town'     => $model->town,
            'postcode'     => $model->postcode,
            'created_at'     => $model->created_at->toFormattedDateString(),
            'updated_at'     => $model->updated_at->toFormattedDateString(),
        ];
    }
}

