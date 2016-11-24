<?php
namespace Topicmine\Content\Models;

use Corcel\Comment as CorcelComment;

class Comment extends CorcelComment
{
    protected $connection = 'wordpress_database';
}
