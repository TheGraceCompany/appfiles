<?php

namespace App\Repositories\Project;

use App\Repositories\RepositoryInterface;

/**
 * Interface ProjectInterface.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
interface ProjectInterface extends RepositoryInterface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
