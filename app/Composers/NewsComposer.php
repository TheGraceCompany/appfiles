<?php

namespace App\Composers;

use News;
use App\Repositories\News\NewsInterface;

/**
 * Class MenuComposer.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class NewsComposer
{
    /**
     * @var \App\Repositories\News\NewsInterface
     */
    protected $news;

    /**
     * NewsComposer constructor.
     * @param NewsInterface $news
     */
    public function __construct(NewsInterface $news)
    {
        $this->news = $news;
    }

    /**
     * @param $view
     */
    public function compose($view)
    {
        $news = $this->news->getLastNews(5);
        $view->with('news', $news);
    }
}
