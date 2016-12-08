<?php



namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function boot()
    {
        // Frontend
        View::composer('frontend/layout/partials/menu/menu', 'App\Composers\MenuComposer');
        View::composer('frontend.layout.partials.menu.menu-cart', 'App\Composers\MenuCartComposer');
        View::composer('frontend/layout/layout', 'App\Composers\SettingComposer');
        View::composer('frontend/layout/footer', 'App\Composers\ArticleComposer');
        View::composer('frontend/layout/partials/footer/footer-widgets', 'App\Composers\ArticleComposer');
        View::composer('frontend/article/show', 'App\Composers\ArticleComposer');
        View::composer('frontend/article/show', 'App\Composers\ArticleComposer');
        View::composer('frontend/news/sidebar', 'App\Composers\NewsComposer');
        // View::composer('frontend/shop/partials/single-lsb/sidebar', 'App\Composers\ArticleComposer');
        View::composer('frontend/shop/partials/single-lsb/sidebar', 'App\Composers\ProductSidebarComposer');
        View::composer('frontend/pages/homepage/parts/blog-section', 'App\Composers\HomePageComposer');

        // Backend
        View::composer('backend/layout/layout', 'App\Composers\Admin\MenuComposer');
    }

    /**
     * Register.
     */
    public function register()
    {
    }
}
