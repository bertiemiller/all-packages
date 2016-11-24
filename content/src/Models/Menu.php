<?php
namespace Topicmine\Content\Models;

use Corcel\Menu as CorcelMenu;

class Menu extends CorcelMenu
{
    protected $connection = 'wordpress_database';
}
