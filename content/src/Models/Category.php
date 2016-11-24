<?php
namespace Topicmine\Content\Models;

use Corcel\TermTaxonomy;

class Category extends TermTaxonomy
{
    /**
     * Used to set the post's type
     */
    protected $taxonomy = 'category';

    protected $connection = 'wordpress_database';

}
