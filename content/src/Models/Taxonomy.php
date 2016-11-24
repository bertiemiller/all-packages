<?php
namespace Topicmine\Content\Models;

use Corcel\TermTaxonomy as CorcelTermTaxonomy;

class Taxonomy extends CorcelTermTaxonomy
{
    protected $connection = 'wordpress_database';
}
