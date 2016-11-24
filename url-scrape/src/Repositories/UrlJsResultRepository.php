<?php
namespace Topicmine\UrlScrape\Repositories;

use Topicmine\Core\Repositories\CoreRepository;
use Topicmine\UrlScrape\Models\UrlJsResult;

class UrlJsResultRepository extends CoreRepository implements UrlJsResultRepositoryInterface {

    public function model()
    {
        return UrlJsResult::class;
    }

    function executeJs($js)
    {
        // Need to install V8Js
        // http://php.net/manual/en/v8js.examples.php

        $v8 = new V8Js();

        try {
            var_dump($v8->executeString($js, 'basic.js'));
        } catch (V8JsException $e) {
            var_dump($e);
        }

//        print '<script>'.$js.'</script>';
    }



    public function getJsResults($selctors)
    {
        var_dump($selctors);
        dd('I would like to build script that scrapes these selectors.');

        $js = file_get_contents( app_path() . '/../public/js/scripts/domvarsbyjs.js'); // compiled by gulp
//        $js = file_get_contents(public_path() . '/js/scripts/domvarsbyjs.js'); // original script file
        return $this->executeJs($js);
    }

}