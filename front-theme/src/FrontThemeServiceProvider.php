<?php
namespace Topicmine\FrontTheme;

use DB;
use View;
use Topicmine\Content\Models\Category;
use Illuminate\Support\ServiceProvider;
use Topicmine\Core\Providers\Traits\CoreServiceProviderHelper;


class FrontThemeServiceProvider extends ServiceProvider {

    use CoreServiceProviderHelper;

    protected $defer = false;

    public function boot()
    {
        if ($this->isVendorPublish())
        {
            print "\nFrontThemeServiceProvider...\n\n";
            $this->updateGulpFile();
        }

        $this->publishes([
            __DIR__ . '/../publish' => base_path(),
        ]);

        view()->composer(
            [
                'home',
                'front.statics.*',
                'auth.*',
                'front.panels.*',
            ],
            'Topicmine\FrontTheme\ViewComposers\FrontLayoutComposer'
        );

        $this->setMainMenu();
    }

    public function register()
    {

    }

    public function setMainMenu()
    {
        View::composer('front.layout._header', function ($view)
        {
            try
            {
                if (config('database.connections.wordpress_database') && DB::connection('wordpress_database')->getDatabaseName())
                {
                    $menu = Category::slug('topic-mine-main-menu')
                        ->posts()
                        ->first()
                        ->posts
                        ->sortBy('menu_order');

                    if (count($menu) > 0)
                    {
                        $view->_menu_ul = $menu;
                    } else
                    {
                        $view->_menu_ul = $this->getDummyMenu();
                    }

                } else
                {
                    $view->_menu_ul = $this->getDummyMenu();
                }
            } catch (Exception $e)
            {
                $view->_menu_ul = $this->getDummyMenu();
            }
        });
    }

    public function getDummyMenu()
    {
        $menuItem = (object) 'MenuItem';
        $menuItem->post_name = 'products';
        $menuItem->post_title = 'Products';
        $menuItem2 = (object) 'MenuItem';
        $menuItem2->post_name = ' subscribe';
        $menuItem2->post_title = 'Subscribe';

        return [$menuItem, $menuItem2];
    }

    public function updateGulpFile()
    {
        $sourceFile = [
            'path'          => base_path() . '/gulpfile.js',
            'matchPosition' => '/(elixir\(mix\s=>\s\{)/',
        ];
        $newFile = [
            'path'               => __DIR__ . '/../includes/gulpfile.js',
            'matchExists'        => '/public\/css\/front\.css/',
            'matchPositionStart' => '/elixir\(mix\s=>\s\{/',
            'matchPositionEnd'   => '/\}\);/',
        ];

        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);
    }
}