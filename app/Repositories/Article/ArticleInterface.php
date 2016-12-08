<?php

namespace App\Repositories\Article;

use App\Repositories\RepositoryInterface;

/**
 * Interface ArticleInterface.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
interface ArticleInterface extends RepositoryInterface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
