<?php

namespace Topicmine\Core\Repositories\User;

use Topicmine\Core\Models\User\Contact;
use Topicmine\Core\Repositories\CoreRepository;
use Topicmine\Core\Transformers\ContactTransformer;

class ContactRepository extends CoreRepository implements ContactRepositoryInterface {
    
    public function model()
    {
        return Contact::class;
    }

    public function transformer()
    {
        return ContactTransformer::class;
    }

}