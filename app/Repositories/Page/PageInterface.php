<?php

namespace App\Repositories\Page;

use App\Repositories\RepositoryInterface;

/**
 * Interface PageInterface.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
interface PageInterface extends RepositoryInterface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug, $isPublished = false);
}
