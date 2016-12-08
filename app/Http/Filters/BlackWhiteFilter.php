<?php

namespace App\Http\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class BlackWhiteFilter implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(120, 90)->greyscale();
    }
}
