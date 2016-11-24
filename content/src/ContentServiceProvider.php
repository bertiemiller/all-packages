<?php
namespace Topicmine\Content;

use Illuminate\Support\ServiceProvider;
use Topicmine\Content\Models\Category;
use Topicmine\Core\Providers\Traits\CoreServiceProviderHelper;
use View;
use DB;


class ContentServiceProvider extends ServiceProvider
{
    use CoreServiceProviderHelper;

    protected $defer = false;

    public function boot()
    {
        if($this->isVendorPublish())
        {
            print "\nContentServiceProvider...\n\n";
            $this->updateDatabaseConfig();
            $this->publishes([
                __DIR__.'/../publish' => base_path(),
            ]);
        }
    }

    public function register()
    {
        $this->resetWebRoutes([
            base_path('routes/Front/Home.php'),
            base_path('routes/Front/Content.php'),
            base_path('routes/Admin/Home.php'),
            base_path('routes/Admin/AccountHome.php'),
            base_path('routes/Sources/Home.php'),
            base_path('routes/Models/Home.php'),
            base_path('routes/Analytics/Home.php'),
        ]);
    }

    public function updateDatabaseConfig()
    {
        $sourceFile = [
            'path' => base_path() . '/config/database.php',
            'matchPosition' => '/(\'connections\'\s=>\s\[)/',
        ];
        $newFile = [
            'path' => __DIR__ . '/../includes/config/database.stub',
            'matchExists' => '/wordpress_database/',
            'matchPositionStart' => '/return\s\[/',
            'matchPositionEnd' => '/\];/'
        ];

        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);
    }

}