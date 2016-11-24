<?php
namespace Topicmine\AdminTheme;

use Illuminate\Support\ServiceProvider;
use Topicmine\Core\Providers\Traits\CoreServiceProviderHelper;

class AdminThemeServiceProvider extends ServiceProvider
{
    use CoreServiceProviderHelper;

    protected $defer = false;

    public function boot()
    {
        if($this->isVendorPublish())
        {
            print "\nAdminThemeServiceProvider...\n\n";
            $this->updateGulpFile();
            $this->publishes([
                __DIR__.'/../publish' => base_path(),
            ]);
        }

        view()->composer(['admin.panels.*', 'admin.statics.*'], function($view) {
            $view->masterView = 'admin.layout.master';
        });
    }

    public function register()
    {

    }

    public function updateGulpFile()
    {
        $sourceFile = [
            'path' => base_path() . '/gulpfile.js',
            'matchPosition' => '/(elixir\(mix\s=>\s\{)/',
        ];
        $newFile = [
            'path' => __DIR__ . '/../includes/gulpfile.js',
            'matchExists' => '/public\/admin-theme\/css\/admin\.css/',
            'matchPositionStart' => '/elixir\(mix\s=>\s\{/',
            'matchPositionEnd' => '/\}\);/',
        ];

        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);
    }

}