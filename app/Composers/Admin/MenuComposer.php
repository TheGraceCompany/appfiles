<?php

namespace App\Composers\Admin;

use App\Models\FormPost;

/**
 * Class MenuComposer.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class MenuComposer
{
    /**
     * @param $view
     */
    public function compose($view)
    {
        $view->with('formPost', FormPost::where('is_answered', 0)->get());
    }
}
