<?php
namespace Topicmine\UrlScrape\Transformers;

//use App\Models\Data\Topic\Topic;
use League\Fractal\TransformerAbstract;
use Form;

class UrlTransformer extends TransformerAbstract {

    public function transform($model)
    {
        return [

            'id'       => $model->id,

            'url'     => $model->url,

            '__action:normal_scrape' => [
                'actionName' => 'Run',
                'actionMethod' => 'actionScrape',
                'postMethod' => 'POST'
            ],

            '__link:url_results' => [
                'url' => route( core()->routeBase().'.urlResults', $model->id, false),
                'actionName' => 'Get Results',
            ],

            '__link:js_scrape' => [
                'url' => route( core()->routeBase().'.jsScrape', $model->id, false),
                    'actionName' => 'Run',
            ],

        ];

    }
}
