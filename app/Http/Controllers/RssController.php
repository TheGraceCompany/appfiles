<?php

namespace App\Http\Controllers;

use App\Feeder\Facade\Feeder;
use App\Models\News;
use Response;

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

        $data = [];
        foreach ($items as $k => $v) {
            $data[] = ['title' => $v->title, 'description' => $v->content, 'link' => url($v->url)];
        }

        $feed = Feeder::feed($data);

        return Response::make($feed, 200, ['Content-Type' => 'text/xml']);
    }
}
