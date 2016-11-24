<?php
namespace Topicmine\Content\Models;

use Corcel\User as CorcelUser;

class User extends CorcelUser
{    
    protected $connection = 'wordpress_database';
}
