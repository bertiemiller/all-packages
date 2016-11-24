<?php

namespace Topicmine\Core\Providers\Traits;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

trait CoreServiceProviderHelper {

    public function isVendorPublish()
    {
        $argv = request()->server->get('argv');
        if(config('isVendorPublish') === true ||
            (
                is_array($argv)
                && isset($argv[0])
//                && ( $argv[0] == 'artisan' ||  $argv[0] == 'composer' )
                && ( $argv[0] == 'artisan' )
                && isset($argv[1]) &&  $argv[1] == 'vendor:publish'
    //            && isset($argv[2]) &&  $argv[2] == '--force'
            )
        ) {
            config(['isVendorPublish' => true]);
            return true;
        }

        config(['isVendorPublish' => false]);
        return false;
    }

    public function resetWebRoutes($routes)
    {
        if(!$this->isVendorPublish())
        {
            if(! is_array($routes) && is_string($routes)) {
                $routes = [$routes];
            }

            app()['router']->group(['namespace' => '\\', 'middleware' => 'web'], function () use ($routes)
            {
                foreach ($routes as $route)
                {
                    require $route;
                }
            });
        }
    }

    public function cleanDirectory($path)
    {
        if(! is_dir($path)) {
            return false;
        }

        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        foreach($objects as $name => $object){
            if(! is_dir($name) && ! str_contains($name,['\.'])) {
                unlink($name);
            }
        }
    }

    public function publishStubs($dir)
    {
        $Directory = new RecursiveDirectoryIterator(realpath($dir));
        $Iterator = new RecursiveIteratorIterator($Directory);
        $Regex = new RegexIterator($Iterator, '/^.+\.stub/i', RecursiveRegexIterator::GET_MATCH);

        foreach($Regex as $name => $fileObj) {
            $newFile = base_path() . str_replace('.stub','.php', explode('publish-stubs', $name)[1]);
            print "\nCopying file to: $newFile";
            copy($name, $newFile);
        }
    }

    public function addPackageSeeder($seederClass)
    {
        $file = base_path() . '/database/seeds/DatabaseSeeder.php';
        $subject = file_get_contents($file);
        $seeder = '$this->call('.$seederClass.'::class);';
        if(! preg_match('/'.$seederClass.'/', $subject) ) {
            $pattern = '/(\}[\s\t\n]+\})/';
            preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);
            $runFunctionClose = $matches[0][0];
//            var_dump($runFunctionClose);
            $replaceWith ="\n\t\t$seeder\n\t". $runFunctionClose;
            $new = str_replace($runFunctionClose, $replaceWith, $subject);
            file_put_contents($file, $new);
        }
    }

    public function replaceContentsInFile2($sourceFile, $newFile)
    {
        $sourceFilePath = $sourceFile['path'];
        $newFilePath = $newFile['path'];
        $newFileMatch = $newFile['matchExists'];

        if(! file_exists($sourceFilePath)) {
            return false;
        }

        $sourceFileContents = file_get_contents($sourceFilePath);
        $newFileContents = file_get_contents($newFilePath);

        if($newFileMatch === false || ! preg_match($newFileMatch, $sourceFileContents) )
        {
            file_put_contents($sourceFilePath, $newFileContents);
        }
    }

    public function addContentsToEndOfFile2($sourceFile, $newFile)
    {
        $sourceFilePath = $sourceFile['path'];
        $newFilePath = $newFile['path'];
        $newFileMatch = $newFile['matchExists'];

        if(! file_exists($sourceFilePath)) {
            return false;
        }

        $sourceFileContents = file_get_contents($sourceFilePath);
        $newFileContents = file_get_contents($newFilePath);
        $newFileContents = str_replace('<?php','',$newFileContents);

        if(! preg_match($newFileMatch, $sourceFileContents) )
        {
            file_put_contents($sourceFilePath, $sourceFileContents . $newFileContents);
        }
    }

    public function addStringToFileAfterMatch2($sourceFile, $newfile){

        $sourceFilePath = $sourceFile['path'];
        $sourceFilePostion = $sourceFile['matchPosition'];
        $newFileContents = $newfile['contents'];
        $newStringMatch = $newfile['matchExists'];

        if(! file_exists($sourceFilePath)) {
            return false;
        }

        $sourceFileContents = file_get_contents($sourceFilePath);

        if(! preg_match($newStringMatch ,$sourceFileContents))
        {
            // Formatting new content: remove last line and add space before
            $newFileContents = "\n" . preg_replace('/\n$/','',$newFileContents);

            // Find the match and append new content
            if(preg_match($sourceFilePostion, $sourceFileContents, $matches, PREG_OFFSET_CAPTURE) )
            {
                $replace = $matches[0][0] . $newFileContents;
                $new = str_replace($matches[0][0], $replace, $sourceFileContents);
                file_put_contents($sourceFilePath, $new);
            }
            else{
                dd('Error appending to file - could not find match: ' . $sourceFilePostion);
            }
        }
    }

    public function addContentsToFileAfterMatch2($sourceFile, $newFile){

        $sourceFilePath = $sourceFile['path'];
        $sourceFilePostion = $sourceFile['matchPosition'];
        $newFilePath = $newFile['path'];
        $newFileMatch = $newFile['matchExists'];
        $newFileContentsStart = $newFile['matchPositionStart'];
        $newFileContentsEnd = $newFile['matchPositionEnd'];

        if(! file_exists($sourceFilePath)) {
            return false;
        }

        $sourceFileContents = file_get_contents($sourceFilePath);

        if(! preg_match($newFileMatch ,$sourceFileContents))
        {
            $newFileContents = file_get_contents($newFilePath);
            $newFileContents = str_replace('<?php','',$newFileContents);

            if(false !== $newFileContentsStart) {
                $newFileContents = preg_split($newFileContentsStart, $newFileContents)[1];
            }

            if(false !== $newFileContentsEnd) {
                $newFileContents = preg_split($newFileContentsEnd, $newFileContents)[0];
            }

            // Formatting new content: remove last line and add space before
            $newFileContents = "\n" . preg_replace('/\n$/','',$newFileContents);

            // Find the match and append new content
            if(preg_match($sourceFilePostion, $sourceFileContents, $matches, PREG_OFFSET_CAPTURE) )
            {
                $replace = $matches[0][0] . $newFileContents;
                $new = str_replace($matches[0][0], $replace, $sourceFileContents);
                file_put_contents($sourceFilePath, $new);
            }
            else{
                dd('Error appending to file - could not find match: ' . $sourceFilePostion);
            }

        }
    }

}