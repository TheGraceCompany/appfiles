<?php

/*
 * @author Phillip Madsen
 */

namespace App\Http\Filters;

use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class WidgetFilter implements FilterInterface
{
    // DIMENSIONS:
        //  96 x 96 pixels  // sidebar

    public function applyFilter(Image $image)
    {
        return $image->encode('jpg', 90)->resize(400, 300);
    }
}
