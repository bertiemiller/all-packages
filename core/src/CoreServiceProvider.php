<?php

namespace Topicmine\Core;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Topicmine\Core\Models\Core;
use Topicmine\Core\Models\AjaxFlash;
use Topicmine\Core\Models\Repo;
use Topicmine\Core\Providers\Traits\CoreServiceProviderHelper;
use Illuminate\Support\Facades\Blade;
use Auth;

class CoreServiceProvider extends ServiceProvider {

    use CoreServiceProviderHelper;

    protected $defer = false;

    public function boot()
    {
        if ($this->isVendorPublish())
        {
            print "\nCoreServiceProvider...\n\n";

            $this->publishes([
                __DIR__ . '/../publish' => base_path(),
            ]);

            // Clean files
            $this->cleanRouteFiles();
            $this->cleanHttpKernelFile();
            $this->cleanGulpFile();
            $this->cleanSidebarConfig();

            // Publish stubs
            $this->publishStubs(__DIR__ . '/../publish-stubs/');

            // Set content matches
            $this->updateHttpKernelFile();
            $this->updateRoutesWebFile();
            $this->updateJavscriptFile();
            $this->updateDatabaseSeedsFile();
            $this->updateAppConfigFile();
        }

        view()->composer(
            ['errors.*'],
            'Topicmine\Core\ViewComposers\ErrorsViewComposer'
        );

        $this->registerBladeExtensions();
    }

    public function register()
    {
        app()->register(\Laracasts\Utilities\JavaScript\JavaScriptServiceProvider::class);
        app()->register(\Prettus\Repository\Providers\RepositoryServiceProvider::class);
        app()->register(\Robbo\Presenter\PresenterServiceProvider::class);
        app()->register(\Collective\Html\HtmlServiceProvider::class);
        app()->register(\Laracasts\Flash\FlashServiceProvider::class);
        app()->register(\HieuLe\Active\ActiveServiceProvider::class);
        app()->register(\Barryvdh\Cors\ServiceProvider::class);
        app()->register(\Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class);
        app()->register(\Dingo\Api\Provider\LaravelServiceProvider::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('Html', \Collective\Html\HtmlFacade::class);
        $loader->alias('Flash', \Laracasts\Flash\Flash::class);
        $loader->alias('Active', \HieuLe\Active\Facades\Active::class);
        $loader->alias('APIRoute', \Dingo\Api\Facade\Route::class);
        $loader->alias('API', \Dingo\Api\Facade\API::class);
        $loader->alias('JWTAuth', \Tymon\JWTAuth\Facades\JWTAuth::class);
        $loader->alias('JWTFactory', \Tymon\JWTAuth\Facades\JWTFactory::class);

        // Reset namespaces and add web middleware by default
        $this->resetWebRoutes([
                base_path('routes/Front/Home.php'),
                base_path('routes/Auth/Auth.php'),
            ]);

        // Core bindings
        $this->app->bind("\\TopicMine\\Core\\Repositories\\CoreRepositoryInterface",
            "TopicMine\\Core\\Repositories\\CoreRepository");

        // Package bindings
        if (config('core.bindings.repositories'))
        {
            foreach (config('core.bindings.repositories') as $repository)
            {
                $this->app->bind("{$repository}RepositoryInterface",
                    "{$repository}Repository");
            }
        }

        // Instances
        $this->app->singleton('repo', function ($app)
        {
            return new Repo($app);
        });

        $this->app->singleton('core', function ($app)
        {
            return new Core($app);
        });

        $this->app->singleton('ajax_flash', function ($app)
        {
            return new AjaxFlash($app);
        });

        $this->app->singleton('account', function ($app)
        {
            $a = new \App\Account;

            return $a->find(Auth::user()->account_id);
        });

        // Setting default template variables
        // Will be overriden by core
        // defaults if not set
        view()->share('title', false);
        view()->share('metaDescription', false);
        view()->share('h1', false);
        view()->share('masterView', 'core.layout.master');
    }

    public function updateAppConfigFile()
    {
        $sourceFile = base_path() . '/config/app.php';
        $sourceFileContents = file_get_contents($sourceFile);
        $newContents = str_replace('\'name\' => \'Laravel\'', '\'name\' => \'Topic Mine\'', $sourceFileContents);
        file_put_contents($sourceFile, $newContents);
    }

    public function updateDatabaseSeedsFile()
    {
        $sourceFile = [
            'path' => base_path() . '/database/seeds/DatabaseSeeder.php',
        ];
        $newFile = [
            'path'        => __DIR__ . '/../includes/database/seeds/DatabaseSeeder.stub',
            'matchExists' => '/CoreUsersTableSeeder/'
        ];
        $this->replaceContentsInFile2($sourceFile, $newFile);
    }

    public function updateJavscriptFile()
    {
        $sourceFile = [
            'path' => base_path() . '/config/javascript.php',
        ];
        $newFile = [
            'path'        => __DIR__ . '/../includes/config/javascript.stub',
            'matchExists' => '/core\.includes\._javascript_variables/'
        ];
        $this->replaceContentsInFile2($sourceFile, $newFile);
    }

    public function cleanSidebarConfig()
    {
        $this->cleanDirectory(base_path() . '/config/admin/sidebar');
    }

    public function cleanGulpFile()
    {
        $sourceFile = [
            'path' => base_path() . '/gulpfile.js',
        ];
        $newFile = [
            'path'        => __DIR__ . '/../includes/gulpfile-reset.js',
            'matchExists' => false
        ];
        $this->replaceContentsInFile2($sourceFile, $newFile);
    }

    public function cleanHttpKernelFile()
    {
        $sourceFile = [
            'path' => base_path() . '/app/Http/Kernel.php',
        ];
        $newFile = [
            'path'        => __DIR__ . '/../includes/app/Http/Kernel.stub',
            'matchExists' => false
        ];
        $this->replaceContentsInFile2($sourceFile, $newFile);
    }

    public function cleanRouteFiles()
    {
        $path = base_path() . '/routes';
        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($objects as $name => $object)
        {
            if (!is_dir($name) && !str_contains($name, ['\.']))
            {
                file_put_contents($name, "<?php\n");
            }
        }
    }

    public function updateGulpFile()
    {
        $sourceFile = [
            'path'          => base_path() . '/gulpfile.js',
            'matchPosition' => '/(elixir\(mix\s=>\s\{)/',
        ];
        $newFile = [
            'path'               => __DIR__ . '/../includes/gulpfile-core.js',
            'matchExists'        => '/javascripts\/bootstrap\.min\.js/',
            'matchPositionStart' => '/elixir\(mix\s=>\s\{/',
            'matchPositionEnd'   => '/\}\);/'
        ];
        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);
    }

    public function updateRoutesWebFile()
    {
        $sourceFile = [
            'path' => base_path() . '/routes/web.php',
        ];
        $newFile = [
            'path'        => __DIR__ . '/../includes/routes/web.stub',
            'matchExists' => '/base_path\(\)\s\.\s\'\/routes\/tmp\'/'
        ];
        $this->replaceContentsInFile2($sourceFile, $newFile);
    }

    public function updateHttpKernelFile()
    {
        // Add parent $bootstrappers to Http/Kernel.php
        $sourceFile = [
            'path'          => app_path() . '/Http/Kernel.php',
            'matchPosition' => '/(class Kernel extends HttpKernel[\s\t\n]+{)/',
        ];
        $newFile = [
            'path'               => __DIR__ . '/../includes/app/Http/Kernel/bootstrappers.stub',
            'matchExists'        => '/\$bootstrappers/',
            'matchPositionStart' => '/class\sKernel\s\{/',
            'matchPositionEnd'   => '/\}/'
        ];
        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);

        // Add routeMiddleware to Http/Kernel.php
        $sourceFile = [
            'path'          => app_path() . '/Http/Kernel.php',
            'matchPosition' => '/(protected\s\$routeMiddleware\s\=\s\[)/',
        ];
        $newFile = [
            'path'               => __DIR__ . '/../includes/app/Http/Kernel/routeMiddleware.stub',
            'matchExists'        => '/GetUserFromToken/',
            'matchPositionStart' => '/\$routeMiddleware\s=\s\[/',
            'matchPositionEnd'   => '/\];/'
        ];
        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);

        // Add middlewareGroups to Http/Kernel.php
        $sourceFile = [
            'path'          => app_path() . '/Http/Kernel.php',
            'matchPosition' => '/(protected\s\$middleware\s\=\s\[)/',
        ];
        $newFile = [
            'path'               => __DIR__ . '/../includes/app/Http/Kernel/middleware.stub',
            'matchExists'        => '/HandlePreflight/',
            'matchPositionStart' => '/\$middleware\s=\s\[/',
            'matchPositionEnd'   => '/\];/'
        ];
        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);
    }

    protected function registerBladeExtensions()
    {
        Blade::directive('hasRole', function ($role)
        {
            return "<?php if (auth_user()->hasRole({$role})): ?>";
        });

        Blade::directive('hasOneOrMoreRoles', function ($roles)
        {
            return "<?php if (auth_user()->hasRoles({$roles})): ?>";
        });

        Blade::directive('hasRoles', function ($roles)
        {
            return '<?php if (auth_user()->hasRoles(' . $roles . ', true)): ?>';
        });

        Blade::directive('hasPermission', function ($permission)
        {
            return "<?php if (auth_user()->isAllowedTo({$permission})): ?>";
        });

        Blade::directive('hasOneOrMorePermission', function ($permissions)
        {
            return "<?php if (auth_user()->isAllowedToMultiple({$permissions})): ?>";
        });

        Blade::directive('hasPermissions', function ($permissions)
        {
            return '<?php if (auth_user()->isAllowedToMultiple(' . $permissions . ', true)): ?>';
        });

        Blade::directive('endauth', function ()
        {
            return '<?php endif; ?>';
        });

        Blade::directive('includephp', function ($path)
        {
            $path = str_replace(['(', ')', "'"], '', $path);

            return '<?php include("' . base_path() . '/resources/views/' . $path . '"); ?>';
        });

        Blade::directive('adminsection', function ($path)
        {
            return '<?php if ( request()->segment(2) == ' . $path . '): ?>';
        });

        Blade::directive('adminsections', function ($paths)
        {
            return '<?php if ( in_array( request()->segment(2), ' . $paths . ' ) ): ?>';
        });
    }
}
