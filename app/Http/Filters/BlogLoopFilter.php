<?php

namespace App\Http\Filters;

use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class BlogLoopFilter implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->encode('jpg', 90)->resize(400, 300);
    }
}
