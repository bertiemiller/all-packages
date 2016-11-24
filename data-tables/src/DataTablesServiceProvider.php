<?php
namespace Topicmine\DataTables;

use Illuminate\Support\ServiceProvider;
use Topicmine\Core\Providers\Traits\CoreServiceProviderHelper;

class DataTablesServiceProvider extends ServiceProvider {

    use CoreServiceProviderHelper;

    protected $defer = false;

    public function boot()
    {
        if($this->isVendorPublish())
        {
            print "\nDataTablesServiceProvider...\n\n";
            $this->updateRoutesAPIFile();
            $this->updateGulpFile();
        }

        $this->publishes([
            __DIR__.'/../publish' => base_path(),
        ]);
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
            'path' =>  __DIR__ . '/../includes/gulpfile.js',
            'matchExists' =>  '/apps\/index\.js/',
            'matchPositionStart' => '/elixir\(mix\s=>\s\{/',
            'matchPositionEnd' =>  '/\}\);/'
        ];
        $this->addContentsToFileAfterMatch2($sourceFile, $newFile);
    }

    public function updateRoutesAPIFile()
    {
        $sourceFile = [
            'path' => base_path() . '/routes/api.php',
        ];
        $newFile = [
            'path' => __DIR__ . '/../includes/routes/api.stub',
            'matchExists' => '/Topicmine\\\\DataTables\\\\Controllers/'
        ];
        $this->addContentsToEndOfFile2($sourceFile, $newFile);
    }
}