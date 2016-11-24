<?php

namespace Topicmine\Content\Models;

use Corcel\Post as CorcelPost;

class Post extends CorcelPost
{
    protected $connection = 'wordpress_database';
}
