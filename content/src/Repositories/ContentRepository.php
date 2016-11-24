<?php
/*
 * http://slashnode.com/reusable-repository-design-in-laravel/
 *
 */
namespace Topicmine\Content\Repositories;

use DB;
use Topicmine\Content\Models\Content;
use Topicmine\Content\Models\Page;
use Topicmine\Core\Repositories\CoreRepository;
use App\Exceptions\PageNotFoundException;

class ContentRepository extends CoreRepository implements ContentRepositoryInterface {
//class ContentRepository implements ContentRepositoryInterface {

    public function wordpressNotSetup()
    {
        return (!config('database.connections.wordpress_database') || !DB::connection('wordpress_database')->getDatabaseName());
    }

    public function model()
    {
        return Content::class;
    }
    
    public function findBySlug(string $slug)
    {
        if ($this->wordpressNotSetup())
        {
            $page = (object) 'Page';
            $page->post_content = file_get_contents(base_path() . '/resources/views/front/statics/dummy.html');
            return $page;
        }

        $page = Page::slug($slug)->first();

        if(null == $page) {
            throw new PageNotFoundException('Page not found');
        }

        return $page;
    }

    public function findPublishedPagesFromParentPath($path)
    {
        if ($this->wordpressNotSetup()) return null;

        $page = Page::status('publish')->where('post_parent', function($query) use ($path){
            $query->select('ID')->from('posts')->where('post_name', $path)->where('post_type', 'page');
        })->get();

        if(null == $page) {
            throw new PageNotFoundException('Page not found');
        }

        return $page;
    }

    public function findPageFromSubCategoryPaths($category,$subCategory,$page)
    {
        if ($this->wordpressNotSetup()) return null;

        $page = Page::slug($page)->where('post_parent', function($query) use ($category,$subCategory){

            $query->select('ID')->from('posts')->where('post_name', $subCategory)->where('post_type', 'page')
                ->where('post_parent', function($query) use ($category) {

                    $query->select('ID')->from('posts')->where('post_name', $category)->where('post_type', 'page');

                });

        })->get()->first();

        if(null == $page) {
            throw new PageNotFoundException('Page not found');
        }

        return $page;
    }

}
