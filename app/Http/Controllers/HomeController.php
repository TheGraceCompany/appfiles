<?php
namespace App\Http\Controllers;

use LaravelLocalization;
use Ecommerce\helperFunctions;

/**
 * Class HomeController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class HomeController extends Controller
{
    public function index()
    {
        $languages = LaravelLocalization::getSupportedLocales();

        helperFunctions::getCartInfo($cart, $total);
        return view('frontend/layout/homepage', compact('languages', 'cart', 'total'));
    }
}
