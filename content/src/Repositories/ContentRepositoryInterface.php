<?php

namespace Topicmine\Content\Repositories;

use Topicmine\Core\Repositories\CoreRepositoryInterface;

interface ContentRepositoryInterface extends CoreRepositoryInterface
//interface ContentRepositoryInterface
{
    public function findBySlug(string $slug);
    public function findPublishedPagesFromParentPath($path);
    public function findPageFromSubCategoryPaths($category,$subCategory,$page);

}
