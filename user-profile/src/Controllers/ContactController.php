<?php

namespace Topicmine\UserProfile\Controllers;

use Topicmine\Core\Repositories\User\ContactRepositoryInterface;
use Topicmine\DataTables\Controllers\DataTablesController;

class ContactController extends DataTablesController
{
    public $modelOwner = 'App\User';
    public $modelRelation = 'contacts';

    public function __construct(ContactRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }

}
