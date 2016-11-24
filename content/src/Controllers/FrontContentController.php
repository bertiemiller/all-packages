<?php

namespace Topicmine\Content\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Topicmine\Content\Repositories\ContentRepositoryInterface;
use DB;
use Request;
use Topicmine\Content\Repositories\ContentRepositoryInterface;

class FrontContentController extends Controller
{
    public function __construct(ContentRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
    
    public function index()
    {
        $item = $this->repo->findBySlug(Request::path());
        $rows = $this->repo->findPublishedPagesFromParentPath(Request::path());

        view()->share('title', $item->post_title);
        view()->share('metaDescription', $item->post_title);
        view()->share('h1', $item->post_title);

        return view('front.panels.wp_rows', ['item' => $item, 'rows' => $rows]);
    }

    /*
     * The routes below are untested
     */
    public function showCategoryPage($category, $page)
    {
        $item = $this->repo->findPageFromPath($page);

        return view('front.panels.wp_row', ['item' => $item]);
    }

    public function showSubCategoryPage($category, $subCategory, $page)
    {
        $item = $this->repo->findPageFromSubCategoryPaths($category,$subCategory,$page);
        
        return view('front.panels.wp_row', ['item' => $item]);
    }

    public function showSubSubCategoryPage()
    {

    }
    
    public function destroy($id)
    {

    }

}