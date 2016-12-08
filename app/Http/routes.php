<?php

/*
 * @author Phillip Madsen
 */

// if(Config::get('app.debug'))
// {
//     array_push($middleware, ['middleware' => 'clearcache']);
// }

// Route::group($middleware, function() {

/*
|--------------------------------------------------------------------------
| MODEL BINDING INTO ROUTE
|--------------------------------------------------------------------------
 */

//Route::model('article', 'App\Models\Article');
// Route::pattern('slug', '[a-z0-9- _]+');

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
 */

$languages = LaravelLocalization::getSupportedLocales();
foreach ($languages as $language => $values) {
    $supportedLocales[] = $language;
}

$locale = Request::segment(1);
if (in_array($locale, $supportedLocales)) {
    LaravelLocalization::setLocale($locale);
    App::setLocale($locale);
}

Route::get('/', function () {
    return Redirect::to(LaravelLocalization::getCurrentLocale(), 302);
});

Route::group(['prefix' => LaravelLocalization::getCurrentLocale(), 'before' => ['localization', 'before']], function () {
    Session::put('my.locale', LaravelLocalization::getCurrentLocale());

    // frontend dashboard
    Route::get('/', ['as' => 'dashboard', 'uses' => 'HomeController@index']);

    // article
    Route::get('/community/blog', ['as' => 'dashboard.article', 'uses' => 'ArticleController@index']);
    Route::get('/community/blog/{slug}', ['as' => 'dashboard.article.show', 'uses' => 'ArticleController@show']);

    // news
    Route::get('/community/news', ['as' => 'dashboard.news', 'uses' => 'NewsController@index']);
    Route::get('/community/news/{slug}', ['as' => 'dashboard.news.show', 'uses' => 'NewsController@show']);
    // video
    Route::get('/community/video', ['as' => 'dashboard.video', 'uses' => 'VideoController@index']);
    Route::get('/community/video/{slug}', ['as' => 'dashboard.video.show', 'uses' => 'VideoController@show']);

    // projects
    //Route::get('/community/project', ['as' => 'dashboard.project', 'uses' => 'ProjectController@index']);
    //Route::get('/community/project/{slug}', ['as' => 'dashboard.project.show', 'uses' => 'ProjectController@show']);
    // faq
    Route::get('/community/faq', ['as' => 'faq', 'uses' => 'FaqController@show']);

    // tags
    Route::get('/tag/{slug}', ['as' => 'dashboard.tag', 'uses' => 'TagController@index']);

    // categories
    Route::get('/category/{slug}', ['as' => 'dashboard.category', 'uses' => 'CategoryController@index']);

    // page
    Route::get('/page', ['as' => 'dashboard.page', 'uses' => 'PageController@index']);
    Route::get('/page/{slug}', ['as' => 'dashboard.page.show', 'uses' => 'PageController@show']);

    // photo gallery
    Route::get('/photo-gallery/{slug}', [
        'as'   => 'dashboard.photo_gallery.show',
        'uses' => 'PhotoGalleryController@show',
    ]);

    // contact
    Route::get('/contact', ['as' => 'dashboard.contact', 'uses' => 'FormPostController@getContact']);

    // rss
    Route::get('/rss', ['as' => 'rss', 'uses' => 'RssController@index']);

    // search
    Route::get('/search', ['as' => 'admin.search', 'uses' => 'SearchController@index']);

    // language
    // Route::get('/set-locale/{language}', array('as' => 'language.set', 'uses' => 'LanguageController@setLocale'));
    // maillist
    Route::get('/save-maillist', ['as' => 'frontend.maillist', 'uses' => 'MaillistController@getMaillist']);
    Route::post('/save-maillist', ['as' => 'frontend.maillist.post', 'uses' => 'MaillistController@postMaillist']);
});

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
 */

Route::group(['prefix' => LaravelLocalization::getCurrentLocale()], function () {
    Route::group([
        'prefix'     => 'admin',
        'middleware' => ['before', 'sentinel.auth', 'sentinel.permission'],
    ], function () {
        Route::get('sections', ['as'=> 'admin.sections.index', 'uses' => 'SectionController@index']);
        Route::get('sections/index', ['as'=> 'admin.sections.index', 'uses' => 'SectionController@index']);
        Route::post('sections/store', ['as'=> 'admin.sections.store', 'uses' => 'SectionController@store']);
        Route::get('sections/show', ['as'=> 'admin.sections.show', 'uses' => 'SectionController@show']);
        Route::get('sections/create', ['as'=> 'admin.sections.create', 'uses' => 'SectionController@create']);
        Route::put('sections/{sections}', ['as'=> 'admin.sections.update', 'uses' => 'SectionController@update']);
        Route::patch('sections/update/{sections}', ['as'=> 'admin.sections.update', 'uses' => 'SectionController@update']);
        Route::delete('sections/{sections}', ['as'=> 'admin.sections.destroy', 'uses' => 'SectionController@destroy']);
        Route::get('sections/{sections}/show', ['as'=> 'admin.sections.show', 'uses' => 'SectionController@show']);
        Route::get('sections/{sections}/edit', ['as'=> 'admin.sections.edit', 'uses' => 'SectionController@edit']);

        Route::get('categories', ['as'=> 'admin.categories.index', 'uses' => 'Admin\CategoryController@index']);
        Route::get('categories/index', ['as'=> 'admin.categories.index', 'uses' => 'Admin\CategoryController@index']);
        Route::post('categories/store', ['as'=> 'admin.categories.store', 'uses' => 'Admin\CategoryController@store']);
        Route::get('categories/show', ['as'=> 'admin.categories.show', 'uses' => 'Admin\CategoryController@show']);
        Route::get('categories/create', ['as'=> 'admin.categories.create', 'uses' => 'Admin\CategoryController@create']);
        Route::put('categories/{categories}', ['as'=> 'admin.categories.update', 'uses' => 'Admin\CategoryController@update']);
        Route::patch('categories/update/{categories}', ['as'=> 'admin.categories.update', 'uses' => 'Admin\CategoryController@update']);
        Route::delete('categories/{categories}', ['as'=> 'admin.categories.destroy', 'uses' => 'Admin\CategoryController@destroy']);
        Route::get('categories/{categories}/show', ['as'=> 'admin.categories.show', 'uses' => 'Admin\CategoryController@show']);
        Route::get('categories/{categories}/edit', ['as'=> 'admin.categories.edit', 'uses' => 'Admin\CategoryController@edit']);

        Route::get('faqs', ['as'=> 'admin.faqs.index', 'uses' => 'FaqController@index']);
        Route::post('faqs', ['as'=> 'admin.faqs.store', 'uses' => 'FaqController@store']);
        Route::get('faqs/create', ['as'=> 'admin.faqs.create', 'uses' => 'FaqController@create']);
        Route::put('faqs/{faqs}', ['as'=> 'admin.faqs.update', 'uses' => 'FaqController@update']);
        Route::patch('faqs/{faqs}', ['as'=> 'admin.faqs.update', 'uses' => 'FaqController@update']);
        Route::delete('faqs/{faqs}', ['as'=> 'admin.faqs.destroy', 'uses' => 'FaqController@destroy']);
        Route::get('faqs/{faqs}', ['as'=> 'admin.faqs.show', 'uses' => 'FaqController@show']);
        Route::get('faqs/{faqs}/edit', ['as'=> 'admin.faqs.edit', 'uses' => 'FaqController@edit']);

        Route::get('boxes', ['as'=> 'admin.boxes.index', 'uses' => 'BoxController@index']);
        Route::post('boxes', ['as'=> 'admin.boxes.store', 'uses' => 'BoxController@store']);
        Route::get('boxes/create', ['as'=> 'admin.boxes.create', 'uses' => 'BoxController@create']);
        Route::put('boxes/{boxes}', ['as'=> 'admin.boxes.update', 'uses' => 'BoxController@update']);
        Route::patch('boxes/{boxes}', ['as'=> 'admin.boxes.update', 'uses' => 'BoxController@update']);
        Route::delete('boxes/{boxes}', ['as'=> 'admin.boxes.destroy', 'uses' => 'BoxController@destroy']);
        Route::get('boxes/{boxes}', ['as'=> 'admin.boxes.show', 'uses' => 'BoxController@show']);
        Route::get('boxes/{boxes}/edit', ['as'=> 'admin.boxes.edit', 'uses' => 'BoxController@edit']);

        Route::get('shippingmethods', ['as'=> 'admin.shippingmethods.index', 'uses' => 'ShippingmethodController@index']);
        Route::post('shippingmethods', ['as'=> 'admin.shippingmethods.store', 'uses' => 'ShippingmethodController@store']);
        Route::get('shippingmethods/create', ['as'=> 'admin.shippingmethods.create', 'uses' => 'ShippingmethodController@create']);
        Route::put('shippingmethods/{shippingmethods}', ['as'=> 'admin.shippingmethods.update', 'uses' => 'ShippingmethodController@update']);
        Route::patch('shippingmethods/{shippingmethods}', ['as'=> 'admin.shippingmethods.update', 'uses' => 'ShippingmethodController@update']);
        Route::delete('shippingmethods/{shippingmethods}', ['as'=> 'admin.shippingmethods.destroy', 'uses' => 'ShippingmethodController@destroy']);
        Route::get('shippingmethods/{shippingmethods}', ['as'=> 'admin.shippingmethods.show', 'uses' => 'ShippingmethodController@show']);
        Route::get('shippingmethods/{shippingmethods}/edit', ['as'=> 'admin.shippingmethods.edit', 'uses' => 'ShippingmethodController@edit']);
    });
    Route::group([
        'prefix'     => '/admin',
        'namespace'  => 'Admin',
        'middleware' => ['before', 'sentinel.auth', 'sentinel.permission'],
    ], function () {
        Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'DashboardController@index']);

        Route::get('user', ['as'=> 'admin.user.index', 'uses' => 'UserController@index']);
        Route::get('user/index', ['as'=> 'admin.user.index', 'uses' => 'UserController@index']);
        Route::post('user/store', ['as'=> 'admin.user.store', 'uses' => 'UserController@store']);
        Route::get('user/show', ['as'=> 'admin.user.show', 'uses' => 'UserController@show']);

        Route::get('user/create', ['as'=> 'admin.user.create', 'uses' => 'UserController@create']);

        Route::put('user/{user}', ['as'=> 'admin.user.update', 'uses' => 'UserController@update']);
        Route::patch('user/update/{user}', ['as'=> 'admin.user.update', 'uses' => 'UserController@update']);
        Route::delete('user/{user}', ['as'=> 'admin.user.destroy', 'uses' => 'UserController@destroy']);
        Route::get('user/{user}/show', ['as'=> 'admin.user.show', 'uses' => 'UserController@show']);
        Route::get('user/{user}/edit', ['as'=> 'admin.user.edit', 'uses' => 'UserController@edit']);

        // user
        // Route::resource('users', 'UserController');
        // Route::get('users/{id}/delete', [
        //     'as'   => 'admin.users.delete',
        //     'uses' => 'UserController@confirmDestroy'
        // ])->where('id', '[0-9]+');

        // role
        Route::resource('role', 'RoleController');
        Route::get('role/{id}/delete', [
            'as'   => 'admin.role.delete',
            'uses' => 'RoleController@confirmDestroy',
        ])->where('id', '[0-9]+');

        // blog
        Route::resource('article', 'ArticleController', ['before' => 'hasAccess:article']);
        Route::get('article/{id}/delete', [
            'as'   => 'admin.article.delete',
            'uses' => 'ArticleController@confirmDestroy',
        ])->where('id', '\d+');

        // news
        Route::resource('news', 'NewsController', ['before' => 'hasAccess:news']);
        Route::get('news/{id}/delete', [
            'as'   => 'admin.news.delete',
            'uses' => 'NewsController@confirmDestroy',
        ])->where('id', '[0-9]+');

        // category
        Route::resource('category', 'CategoryController', ['before' => 'hasAccess:category']);
        Route::get('category/{id}/delete', [
            'as'   => 'admin.category.delete',
            'uses' => 'CategoryController@confirmDestroy',
        ])->where('id', '[0-9]+');

        // faq
        Route::resource('faq', 'FaqController', ['before' => 'hasAccess:faq']);
        Route::get('faq/{id}/delete', [
            'as'   => 'admin.faq.delete',
            'uses' => 'FaqController@confirmDestroy',
        ])->where('id', '[0-9]+');

        // project
        Route::resource('project', 'ProjectController');
        Route::get('project/{id}/delete', [
            'as'   => 'admin.project.delete',
            'uses' => 'ProjectController@confirmDestroy',
        ])->where('id', '[0-9]+');

        // page
        //Route::resource('admin/pages', 'Admin\PageController');
        Route::resource('page', 'PageController');
        Route::get('page/{id}/delete', [
            'as'   => 'admin.page.delete',
            'uses' => 'PageController@confirmDestroy',
        ])->where('id', '[0-9]+');

        // photo gallery
        Route::resource('photo-gallery', 'PhotoGalleryController');
        Route::get('photo-gallery/{id}/delete', [
            'as'   => 'admin.photo-gallery.delete',
            'uses' => 'PhotoGalleryController@confirmDestroy',
        ])->where('id', '[0-9]+');

        // video
        Route::resource('video', 'VideoController');
        Route::get('video/{id}/delete', [
            'as'   => 'admin.video.delete',
            'uses' => 'VideoController@confirmDestroy',
        ])->where('id', '[0-9]+');
        Route::post('/video/get-video-detail', [
            'as'   => 'admin.video.detail',
            'uses' => 'VideoController@getVideoDetail',
        ])->where('id', '[0-9]+');

        // ajax - blog
        Route::post('article/{id}/toggle-publish', [
            'as'   => 'admin.article.toggle-publish',
            'uses' => 'ArticleController@togglePublish',
        ])->where('id', '[0-9]+');

        // ajax - news
        Route::post('news/{id}/toggle-publish', [
            'as'   => 'admin.news.toggle-publish',
            'uses' => 'NewsController@togglePublish',
        ])->where('id', '[0-9]+');

        // ajax - photo gallery
        Route::post('photo-gallery/{id}/toggle-publish', [
            'as'   => 'admin.photo_gallery.toggle-publish',
            'uses' => 'PhotoGalleryController@togglePublish',
        ])->where('id', '[0-9]+');
        Route::post('photo-gallery/{id}/toggle-menu', [
            'as'   => 'admin.photo_gallery.toggle-menu',
            'uses' => 'PhotoGalleryController@toggleMenu',
        ])->where('id', '[0-9]+');

        // ajax - page
        Route::post('page/{id}/toggle-publish', [
            'as'   => 'admin.page.toggle-publish',
            'uses' => 'PageController@togglePublish',
        ])->where('id', '[0-9]+');

        Route::post('page/{id}/toggle-menu', [
            'as'   => 'admin.page.toggle-menu',
            'uses' => 'PageController@toggleMenu',
        ])->where('id', '[0-9]+');

        // ajax - form post
        Route::post('form-post/{id}/toggle-answer', [
            'as'   => 'admin.form-post.toggle-answer',
            'uses' => 'FormPostController@toggleAnswer',
        ])->where('id', '[0-9]+');

        // file upload photo gallery
        Route::post('/photo-gallery/upload/{id}', [
            'as'   => 'admin.photo.gallery.upload.image',
            'uses' => 'PhotoGalleryController@upload',
        ])->where('id', '[0-9]+');
        Route::post('/photo-gallery-delete-image', [
            'as'   => 'admin.photo.gallery.delete.image',
            'uses' => 'PhotoGalleryController@deleteImage',
        ]);

        // settings
        Route::get('/settings', ['as' => 'admin.settings', 'uses' => 'SettingController@index']);
        Route::post('/settings', [
            'as'   => 'admin.settings.save',
            'uses' => 'SettingController@save',
        ], ['before' => 'csrf']);

        // form post
        Route::resource('form-post', 'FormPostController', ['only' => ['index', 'show', 'destroy']]);
        Route::get('form-post/{id}/delete', [
            'as'   => 'admin.form-post.delete',
            'uses' => 'FormPostController@confirmDestroy',
        ])->where('id', '[0-9]+');

        // slider
        Route::get('/slider', [
            'as' => 'admin.slider',
            function () {
                return View::make('backend/slider/index');
            },
        ]);

        // slider
        Route::resource('slider', 'SliderController');
        Route::get('slider/{id}/delete', [
            'as'   => 'admin.slider.delete',
            'uses' => 'SliderController@confirmDestroy',
        ])->where('id', '[0-9]+');

        // file upload slider
        Route::post('/slider/upload/{id}', [
            'as'   => 'admin.slider.upload.image',
            'uses' => 'SliderController@upload',
        ])->where('id', '[0-9]+');
        Route::post('/slider-delete-image', [
            'as'   => 'admin.slider.delete.image',
            'uses' => 'SliderController@deleteImage',
        ]);

        // menu-managment
        Route::resource('menu', 'MenuController');
        Route::get('menu', ['as' => 'admin.menu', 'uses' => 'MenuController@index']);
        Route::post('menu/save', ['as' => 'admin.menu.save', 'uses' => 'MenuController@save']);
        Route::get('menu/{id}/delete', [
            'as'   => 'admin.menu.delete',
            'uses' => 'MenuController@confirmDestroy',
        ])->where('id', '[0-9]+');
        Route::post('menu/{id}/toggle-publish', [
            'as'   => 'admin.menu.toggle-publish',
            'uses' => 'MenuController@togglePublish',
        ])->where('id', '[0-9]+');

        // log
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

        // language
        Route::get('language/set-locale/{language}', [
            'as'   => 'admin.language.set',
            'uses' => 'LanguageController@setLocale',
        ]);
    });
});

Route::post('/contact', [
    'as'   => 'dashboard.contact.post',
    'uses' => 'FormPostController@postContact',
], ['before' => 'csrf']);

// filemanager
Route::get('filemanager/show', function () {
    return View::make('backend/plugins/filemanager');
})->before('sentinel.auth');

// login
// Route::get('/admin/login',  ['as' => 'admin.login', function () {return View::make('backend/auth/login'); } ]);

Route::group(['namespace' => 'Admin'], function () {
    // admin auth
    Route::get('admin/logout', ['as' => 'admin.logout', 'uses' => 'AuthController@getLogout']);
    Route::get('admin/login', ['as' => 'admin.login', 'uses' => 'AuthController@getLogin']);
    Route::post('admin/login', ['as' => 'admin.login.post', 'uses' => 'AuthController@postLogin']);
    Route::post('admin/login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
    // admin password reminder
    Route::get('admin/forgot-password', ['as' => 'admin.forgot.password', 'uses' => 'AuthController@getForgotPassword']);
    Route::post('admin/forgot-password', ['as' => 'admin.forgot.password.post', 'uses' => 'AuthController@postForgotPassword']);
    Route::get('admin/{id}/reset/{code}', ['as' => 'admin.reset.password', 'uses' => 'AuthController@getResetPassword'])->where('id', '[0-9]+');
    Route::post('admin/reset-password', ['as' => 'admin.reset.password.post', 'uses' => 'AuthController@postResetPassword']);
});

Route::group(['prefix' => 'api', 'namespace' => 'API'], function () {
    Route::group(['prefix' => 'v1'], function () {
        require 'api_routes.php';
    });
});

// });

Route::get('signin', ['as' => 'signin', 'uses' => 'AuthController@getSignin']);
Route::post('signin', 'AuthController@postSignin');
Route::post('signup', ['as' => 'signup', 'uses' => 'AuthController@postSignup']);
