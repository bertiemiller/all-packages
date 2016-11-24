<?php
namespace Topicmine\UrlScrape\Repositories;

use Topicmine\UrlScrape\Models\UrlHtmlBlob;
use Topicmine\Core\Repositories\CoreRepository;

class UrlHtmlBlobRepository extends CoreRepository implements  UrlHtmlBlobRepositoryInterface {

    public function model()
    {
        return UrlHtmlBlob::class;
    }
}