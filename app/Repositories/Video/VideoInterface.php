<?php

namespace App\Repositories\Video;

use App\Repositories\RepositoryInterface;

/**
 * Interface VideoInterface.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
interface VideoInterface extends RepositoryInterface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
