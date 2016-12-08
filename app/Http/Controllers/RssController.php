<?php

namespace App\Http\Controllers;

use Response;
use App\Models\News;
use App\Feeder\Facade\Feeder;

/**
 * Class RssController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class RssController extends Controller
{
    public function index()
    {
        $items = News::orderBy('created_at', 'desc')->take(10)->get();

        $data = array();
        foreach ($items as $k => $v) {
            $data[] = array('title' => $v->title, 'description' => $v->content, 'link' => url($v->url));
        }

        $feed = Feeder::feed($data);
        return Response::make($feed, 200, array('Content-Type' => 'text/xml'));
    }
}
