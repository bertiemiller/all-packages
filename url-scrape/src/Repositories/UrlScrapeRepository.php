<?php
namespace Topicmine\UrlScrape\Repositories;

use Topicmine\Core\Repositories\CoreRepository;
use Topicmine\UrlScrape\Models\UrlScrape;
use Topicmine\UrlScrape\Transformers\UrlScrapeTransformer;

class UrlScrapeRepository extends CoreRepository implements UrlScrapeRepositoryInterface {

    public function model()
    {
        return UrlScrape::class;
    }

    public function transformer()
    {
        return UrlScrapeTransformer::class;
    }

}