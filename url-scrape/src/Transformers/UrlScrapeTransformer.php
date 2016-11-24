<?php
namespace Topicmine\UrlScrape\Transformers;

use Topicmine\Core\Transformers\RelationTransformer;

class UrlScrapeTransformer extends RelationTransformer {

    public function transform($model)
    {
        return [
            'id'       => $model->id,
            'name'=> $model->name,
            '__relation:urls' => $this->getRelationship($model, 'urls'),
            'created_at'    => $model->created_at->toFormattedDateString(),
            'updated_at'    => $model->updated_at->toFormattedDateString(),
        ];
    }
}
