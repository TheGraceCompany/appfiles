<?php

namespace App\Repositories\PhotoGallery;

use App\Repositories\RepositoryInterface;

/**
 * Interface PhotoGalleryInterface.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
interface PhotoGalleryInterface extends RepositoryInterface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
