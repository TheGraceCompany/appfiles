<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Menu;
use App\Models\News;
use App\Models\Page;
use App\Models\PhotoGallery;
use App\Models\Project;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Video;
use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\CacheDecorator as ArticleCacheDecorator;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Faq\CacheDecorator as FaqCacheDecorator;
use App\Repositories\Faq\FaqRepository;
use App\Repositories\Menu\CacheDecorator as MenuCacheDecorator;
use App\Repositories\Menu\MenuRepository;
use App\Repositories\News\CacheDecorator as NewsCacheDecorator;
use App\Repositories\News\NewsRepository;
use App\Repositories\Page\CacheDecorator as PageCacheDecorator;
use App\Repositories\Page\PageRepository;
use App\Repositories\PhotoGallery\CacheDecorator as PhotoGalleryCacheDecorator;
use App\Repositories\PhotoGallery\PhotoGalleryRepository;
use App\Repositories\Project\CacheDecorator as ProjectCacheDecorator;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Section\SectionRepository;
use App\Repositories\Setting\CacheDecorator as SettingCacheDecorator;
use App\Repositories\Setting\SettingRepository;
use App\Repositories\Slider\CacheDecorator as SliderCacheDecorator;
use App\Repositories\Slider\SliderRepository;
use App\Repositories\Tag\CacheDecorator as TagCacheDecorator;
use App\Repositories\Tag\TagRepository;
use App\Repositories\Video\CacheDecorator as VideoCacheDecorator;
use App\Repositories\Video\VideoRepository;
use App\Services\Cache\FullyCache;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $app = $this->app;

        //dd($app['config']->get('grace.cache'));

        // article
        $app->bind('App\Repositories\Article\ArticleInterface', function ($app) {
            $article = new ArticleRepository(
                new Article()
            );

            //dd($app['config']->get('is_admin', false));

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $article = new ArticleCacheDecorator(
                    $article,
                    new FullyCache($app['cache'], 'articles')
                );
            }

            return $article;
        });

        // category
        $app->bind('App\Repositories\Category\CategoryInterface', function ($app) {
            $category = new CategoryRepository(
                new Category()
            );

            return $category;
        });

        // section
        $app->bind('App\Repositories\Section\SectionInterface', function ($app) {
            $section = new SectionRepository(
                new Section()
            );

            return $section;
        });

        // page
        $app->bind('App\Repositories\Page\PageInterface', function ($app) {
            $page = new PageRepository(
                new Page()
            );

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $page = new PageCacheDecorator(
                    $page,
                    new FullyCache($app['cache'], 'pages')
                );
            }

            return $page;
        });

        // faq
        $app->bind('App\Repositories\Faq\FaqInterface', function ($app) {
            $faq = new FaqRepository(
                new Faq()
            );

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $faq = new FaqCacheDecorator(
                    $faq,
                    new FullyCache($app['cache'], 'faqs')
                );
            }

            return $faq;
        });

        // news
        $app->bind('App\Repositories\News\NewsInterface', function ($app) {
            $news = new NewsRepository(
                new News()
            );

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $news = new NewsCacheDecorator(
                    $news,
                    new FullyCache($app['cache'], 'pages')
                );
            }

            return $news;
        });

        // photo gallery
        $app->bind('App\Repositories\PhotoGallery\PhotoGalleryInterface', function ($app) {
            $photoGallery = new PhotoGalleryRepository(
                new PhotoGallery()
            );

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $photoGallery = new PhotoGalleryCacheDecorator(
                    $photoGallery,
                    new FullyCache($app['cache'], 'photo_galleries')
                );
            }

            return $photoGallery;
        });

        // project
        $app->bind('App\Repositories\Project\ProjectInterface', function ($app) {
            $project = new ProjectRepository(
                new Project()
            );

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $project = new ProjectCacheDecorator(
                    $project,
                    new FullyCache($app['cache'], 'projects')
                );
            }

            return $project;
        });

        // tag
        $app->bind('App\Repositories\Tag\TagInterface', function ($app) {
            $tag = new TagRepository(
                new Tag()
            );

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $tag = new TagCacheDecorator(
                    $tag,
                    new FullyCache($app['cache'], 'tags')
                );
            }

            return $tag;
        });

        // video
        $app->bind('App\Repositories\Video\VideoInterface', function ($app) {
            $video = new VideoRepository(
                new Video()
            );

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $video = new VideoCacheDecorator(
                    $video,
                    new FullyCache($app['cache'], 'pages')
                );
            }

            return $video;
        });

        // menu
        $app->bind('App\Repositories\Menu\MenuInterface', function ($app) {
            $menu = new MenuRepository(
                new Menu()
            );

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $menu = new MenuCacheDecorator(
                    $menu,
                    new FullyCache($app['cache'], 'menus')
                );
            }

            return $menu;
        });

        // slider
        $app->bind('App\Repositories\Slider\SliderInterface', function ($app) {
            $slider = new SliderRepository(
                new Slider()
            );

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $slider = new SliderCacheDecorator(
                    $slider,
                    new FullyCache($app['cache'], 'sliders')
                );
            }

            return $slider;
        });

        // setting
        $app->bind('App\Repositories\Setting\SettingInterface', function ($app) {
            $setting = new SettingRepository(
                new Setting()
            );

            if ($app['config']->get('grace.cache') === true && $app['config']->get('is_admin', false) == false) {
                $setting = new SettingCacheDecorator(
                    $setting,
                    new FullyCache($app['cache'], 'settings')
                );
            }

            return $setting;
        });
    }
}
