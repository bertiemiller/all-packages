<?php
namespace Topicmine\UserAccess;

use Illuminate\Support\ServiceProvider;
use Topicmine\Core\Providers\Traits\CoreServiceProviderHelper;

class UserAccessServiceProvider extends ServiceProvider
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
            print "\nUserAccessServiceProvider...\n\n";
            $this->publishes([
                __DIR__.'/../publish' => base_path(),
            ]);
        }
    }

    public function register()
    {
        $this->resetWebRoutes(base_path('routes/Admin/UserAccess.php'));
    }

}