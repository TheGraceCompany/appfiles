<?php

namespace App\Composers;

use App\Models\Category;
use App\Repositories\Category\CategoryInterface;


/**
 * Class ProductSidebarComposer.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class ProductSidebarComposer
{

    protected $categories;


    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }


    public function compose($view)
    {

    }
}
