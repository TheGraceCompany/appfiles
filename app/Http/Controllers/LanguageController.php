<?php

namespace App\Http\Controllers;

/**
 * Class LanguageController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class LanguageController extends Controller
{
    public function setLocale($language)
    {
        LaravelLocalization::setLocale($language);
        return Redirect::route('dashboard');
    }
}
