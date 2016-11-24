<?php

namespace Topicmine\UrlScrape;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Topicmine\Core\Providers\Traits\CoreServiceProviderHelper;

class UrlScrapeServiceProvider extends ServiceProvider
{
    use CoreServiceProviderHelper;

    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->isVendorPublish())
        {
            print "\nScrapeUrlServiceProvider...\n\n";
            $this->addPackageSeeder('UrlTableSeeder');
            $this->publishes([
                __DIR__.'/../publish' => base_path(),
            ]);
        }
    }

    public function register()
    {
        $this->resetWebRoutes(base_path('routes/Admin/UrlScrape.php'));
    }
}
