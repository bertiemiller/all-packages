<?php

namespace Topicmine\UrlScrape\Controllers;

use Topicmine\Core\Controllers\CoreController;
use Topicmine\DataTables\Controllers\DataTablesController;
use Topicmine\UrlScrape\Repositories\UrlScrapeRepositoryInterface;

//class UrlScrapeController extends DataTablesController
class UrlScrapeController extends CoreController
{
    public function __construct(UrlScrapeRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }
}
