<?php
namespace Topicmine\UserProfile;

use Illuminate\Support\ServiceProvider;
use Topicmine\Core\Providers\Traits\CoreServiceProviderHelper;

class UserProfileServiceProvider extends ServiceProvider
{
    use CoreServiceProviderHelper;

    protected $defer = false;

    public function boot()
    {
        if($this->isVendorPublish())
        {
            print "\nUserProfileServiceProvider...\n\n";
            $this->publishes([
                __DIR__.'/../publish' => base_path(),
            ]);
        }

    }

    public function register()
    {
        $this->resetWebRoutes(base_path('routes/Admin/UserProfile.php'));
    }

}