<?php



namespace App\Http\Filters;

use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class ProductFilter implements FilterInterface
{
    // DIMENSIONS:
        // 720 x 960 pixels
        // 413 x 551 pixels
        // 100 x 75 pixels  // gallery
        //  96 x 96 pixels  // sidebar

    public function applyFilter(Image $image)
    {
        return $image->encode('jpg', 90)->resize(400, 300);
    }
}
