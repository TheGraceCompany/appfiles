<?php



namespace App\Http\Filters;

use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class ShopFilter implements FilterInterface
{
    // DIMENSIONS:
        // 440 x 586 pixels
        // 270 x 360 pixels
        // 300 x 200 pixels
        // 270 x 270 pixels
    public function applyFilter(Image $image)
    {
        return $image->encode('jpg', 90)->resize(400, 300);
    }
}
