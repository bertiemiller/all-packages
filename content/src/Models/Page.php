<?php
namespace Topicmine\Content\Models;

use Corcel\Post;

class Page extends Post
{
    /**
     * Used to set the post's type
     */
    protected $postType = 'page';

    protected $connection = 'wordpress_database';
}
