<?php
namespace Topicmine\Subscription;

use Illuminate\Support\ServiceProvider;
use Topicmine\Core\Providers\Traits\CoreServiceProviderHelper;


class SubscriptionServiceProvider extends ServiceProvider
{
    use CoreServiceProviderHelper;

    protected $defer = false;

    public function boot()
    {
        if($this->isVendorPublish())
        {
            print "\nSubscriptionServiceProvider...\n\n";
            $this->updateHttpKernel();
            $this->updateDatabaseConfig();
            $this->publishes([
                __DIR__.'/../publish' => base_path(),
            ]);
        }
    }

    public function register()
    {
        app()->register(\Laravel\Cashier\CashierServiceProvider::class);
        app()->register(\Cartalyst\Stripe\Laravel\StripeServiceProvider::class);

        // Aliases
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Stripe', \Cartalyst\Stripe\Laravel\Facades\Stripe::class);

        $this->resetWebRoutes([
            base_path('routes/Admin/Subscription.php'),
            base_path('routes/Auth/Auth.php'),
        ]);
    }

    public function updateDatabaseConfig()
    {
        $sourceFile = [
            'path' => base_path() . '/config/database.php',
            'matchPosition' => '/(\'connections\'\s=>\s\[)/',
        ];
        $newFile = [
            'path' =>  __DIR__ . '/../includes/config/database.stub',
            'matchExists' =>  '/account_database/',
            'matchPositionStart' => '/return\s\[/',
            'matchPositionEnd' => '/\];/'
        ];

        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);
    }

    public function updateHttpKernel()
    {
        // Add middlewareGroups to Http/Kernel.php
        $sourceFile = [
            'path' => app_path() . '/Http/Kernel.php',
            'matchPosition' => '/(protected\s\$middlewareGroups\s\=\s\[)/',
        ];
        $newFile = [
            'path' => __DIR__ . '/../includes/app/Http/Kernel/middlewareGroups.stub',
            'matchExists' =>  '/users\.subscriptionSetup/',
            'matchPositionStart' => '/\$middlewareGroups\s=\s\[/',
            'matchPositionEnd' => '/\];/'
        ];
        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);

        // Add routeMiddleware to Http/Kernel.php
        $sourceFile = [
            'path' => app_path() . '/Http/Kernel.php',
            'matchPosition' => '/(protected\s\$routeMiddleware\s\=\s\[)/',
        ];
        $newFile = [
            'path' =>  __DIR__ . '/../includes/app/Http/Kernel/routeMiddleware.stub',
            'matchExists' =>  '/\'users\.subscriptionSetup\'\s=>\s/',
            'matchPositionStart' => '/\$routeMiddleware\s=\s\[/',
            'matchPositionEnd' =>  '/\];/'
        ];
        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);
    }
}