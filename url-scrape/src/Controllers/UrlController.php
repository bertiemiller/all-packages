<?php

namespace Topicmine\UrlScrape\Controllers;

use Illuminate\Http\Request;
use Topicmine\Core\Controllers\CoreController;
use Topicmine\DataTables\Controllers\DataTablesController;
use Topicmine\UrlScrape\Repositories\UrlRepositoryInterface;

//class UrlController extends DataTablesController
class UrlController extends CoreController
{
    public function __construct(UrlRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }

    public function action(Request $request)
    {
        $inputs =  $request->all();
        return ['test'=>$inputs];
    }

    public function scrape($urlId)
    {
        $response = $this->repo->scrapeUrl($urlId);

        flash($response);

        return redirect(core()->routeIndex());
    }

    public function urlResults($urlId)
    {
        $response = $this->repo->urlResults($urlId);

        flash($response);

        return redirect(core()->routeIndex());
    }


    public function jsScrape($urlId)
    {
        $response = $this->repo->jsScrape($urlId);

        flash($response);

        return redirect(core()->routeIndex());
    }


    // This was used for testing without ajax datatables
    // Leaving here if useful for further development

//    public function store(CoreRequest $request)
//    {
//        $inputs = $request->all();
//        unset($inputs['_token']);
//        reset($inputs);
//        $first_key = key($inputs);
//
//        if(is_array($inputs[$first_key])) {
//
//            $data = [];
//            foreach($inputs[$first_key] as $item)
//            {
//                if(empty($item)) continue;
//
//                $data[] = [
//                    $this->repo->modelBase->getFillable()[0] => $item,
//                    'user_id' => 1,
//                    'account_id' => 1,
//                ];
//            }
//
//            $this->repo->modelBase->insert($data);
//
//            return redirect()->route(core()->routeIndexName());
//        }
//
//        $this->repo->modelBase->insert($inputs);
//
//        return redirect()->route(core()->routeIndexName());
//    }

}
