<?php
namespace Topicmine\UrlScrape\Repositories;

use Topicmine\UrlScrape\Models\Url;
use Topicmine\Core\Repositories\CoreRepository;
use Topicmine\UrlScrape\Models\UrlScrape;
use Topicmine\UrlScrape\Transformers\UrlTransformer;
use Goutte\Client as GoutteCient;
use GuzzleHttp\Client as GuzzleHttpClient;

class UrlRepository extends CoreRepository implements UrlRepositoryInterface {

    public function model()
    {
        return Url::class;
    }

    public function transformer()
    {
        return UrlTransformer::class;
    }

    public function actionScrape($inputs)
    {
        $urlId = $inputs['urlId'];
        return $this->scrapeUrl($urlId);
    }

    public function scrapeUrl($urlId)
    {
        $url = $this->find($urlId);

        // check if scrape exist yet
//        if(false === $this->recentScrapeExists($url)) {
//            $response = $this->scrapeAndSaveUrlHtml($url);
//        }

        $response = $this->scrapeAndSaveUrlHtml($url);

        return $response;
    }


    public function urlResults($urlId)
    {
        $url = $this->find($urlId);

        if(false === $this->recentScrapeExists($url)) {
            $this->scrapeAndSaveUrlHtml($url);
        }

        $htmlBlob = $url->latest_html_blobs()->first();

        $urlResultRepo = repo()->make('Topicmine\UrlScrape\Repositories\UrlResult');
        $results = $urlResultRepo->getDomResults(json_decode($htmlBlob->html_blob));

        dd($results);
        return $results;
    }

    public function recentScrapeExists($url)
    {
        // put time limit on this in future
        return !! $url->html_blobs()->where('url_id', $url->id)->first();
    }

    public function jsScrape($urlId)
    {
        // do first scrape
        $url = $this->find($urlId);

        // check if scrape exist yet
        if(false === $this->recentScrapeExists($url)) {
            $this->scrapeAndSaveUrlHtml($url);
        }

        // get dom_results for that url
        $htmlBlob = $url->latest_html_blobs()->first();

        $urlResultRepo = repo()->make('Topicmine\UrlScrape\Repositories\UrlResult');
        $results = $urlResultRepo->getDomResults(json_decode($htmlBlob->html_blob));
        $selectors = $urlResultRepo->getSectors($results);

        // scrape selectors with JS script
        $urlJsResultRepo = repo()->make('Topicmine\UrlScrape\Repositories\UrlJsResult');
        $jsResults = $urlJsResultRepo->getJsResults($selectors);
        dd($jsResults);

        // create best solution to store this in mysql
    }

    public function scrapeAndSaveUrlHtml($url)
    {
        $client = new GoutteCient();
        $guzzleClient = new GuzzleHttpClient(array(
            'timeout' => 60,
        ));

        $client->setClient($guzzleClient);
        $crawler = $client->request('GET', $url->url);

        $html = trim($crawler->filter('html')->html());

        // strip to one line
        // another source - http://stackoverflow.com/questions/6225351/how-to-minify-php-page-html-output
        $html = preg_replace( array('/ {2,}/','/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'), array(' ', ''), $html );

        $htmlBlobRepo = repo()->make('Topicmine\UrlScrape\Repositories\UrlHtmlBlob');
        $htmlBlobRepo->setModelWithRelation(
            'Topicmine\UrlScrape\Repositories\Url',
            'html_blobs',
            $url->id );

        $response = $htmlBlobRepo->model->create([
            'url_id' => $url->id,
            'html_blob' => json_encode($html),
            'user_id' => auth_user()->id,
            'account_id' => account()->id,
        ]);

        if(false !== $response) {
            return 'successful scrape';
        }

        return 'error with scrape';
    }

}