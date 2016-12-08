<?php

/*
 * @author Phillip Madsen
 */

Route::group(['prefix' => LaravelLocalization::getCurrentLocale(), 'before' => ['localization', 'before']], function () {
    Route::group(['middleware' => 'SentinelUser'], function () {

        /*
         * Users Routes
         */
        Route::get('/dashboard', 'UserController@dashboard');
        Route::post('/dashboard/editAccount', 'UserController@editAccount');
        Route::post('/dashboard/editInfo', 'UserController@editInfo');

        Route::get('/user/{id}/delete', 'UserController@delete');
        Route::post('/user/create', 'UserController@store');
        Route::post('/user/{id}/edit', 'UserController@edit');
        Route::post('/user/edit', 'UserController@edit');
    });
});

Route::group(['prefix' => LaravelLocalization::getCurrentLocale(), 'before' => ['localization', 'before']], function () {
    Route::group([
        'prefix'     => '/admin',
        'middleware' => ['before', 'sentinel.auth', 'sentinel.permission'],
    ], function () {
        Route::get('admin/dealers', ['as'=> 'admin.dealers.index', 'uses' => 'DealerController@index']);
        Route::post('admin/dealers', ['as'=> 'admin.dealers.store', 'uses' => 'DealerController@store']);
        Route::get('admin/dealers/create', ['as'=> 'admin.dealers.create', 'uses' => 'DealerController@create']);
        Route::put('admin/dealers/{dealers}', ['as'=> 'admin.dealers.update', 'uses' => 'DealerController@update']);
        Route::patch('admin/dealers/{dealers}', ['as'=> 'admin.dealers.update', 'uses' => 'DealerController@update']);
        Route::delete('admin/dealers/{dealers}', ['as'=> 'admin.dealers.destroy', 'uses' => 'DealerController@destroy']);
        Route::get('admin/dealers/{dealers}', ['as'=> 'admin.dealers.show', 'uses' => 'DealerController@show']);
        Route::get('admin/dealers/{dealers}/edit', ['as'=> 'admin.dealers.edit', 'uses' => 'DealerController@edit']);

        Route::get('admin/locations', ['as'=> 'admin.locations.index', 'uses' => 'LocationController@index']);
        Route::post('admin/locations', ['as'=> 'admin.locations.store', 'uses' => 'LocationController@store']);
        Route::get('admin/locations/create', ['as'=> 'admin.locations.create', 'uses' => 'LocationController@create']);
        Route::put('admin/locations/{locations}', ['as'=> 'admin.locations.update', 'uses' => 'LocationController@update']);
        Route::patch('admin/locations/{locations}', ['as'=> 'admin.locations.update', 'uses' => 'LocationController@update']);
        Route::delete('admin/locations/{locations}', ['as'=> 'admin.locations.destroy', 'uses' => 'LocationController@destroy']);
        Route::get('admin/locations/{locations}', ['as'=> 'admin.locations.show', 'uses' => 'LocationController@show']);
        Route::get('admin/locations/{locations}/edit', ['as'=> 'admin.locations.edit', 'uses' => 'LocationController@edit']);

        Route::get('admin/alerts', ['as'=> 'admin.alerts.index', 'uses' => 'AlertController@index']);
        Route::post('admin/alerts', ['as'=> 'admin.alerts.store', 'uses' => 'AlertController@store']);
        Route::get('admin/alerts/create', ['as'=> 'admin.alerts.create', 'uses' => 'AlertController@create']);
        Route::put('admin/alerts/{alerts}', ['as'=> 'admin.alerts.update', 'uses' => 'AlertController@update']);
        Route::patch('admin/alerts/{alerts}', ['as'=> 'admin.alerts.update', 'uses' => 'AlertController@update']);
        Route::delete('admin/alerts/{alerts}', ['as'=> 'admin.alerts.destroy', 'uses' => 'AlertController@destroy']);
        Route::get('admin/alerts/{alerts}', ['as'=> 'admin.alerts.show', 'uses' => 'AlertController@show']);
        Route::get('admin/alerts/{alerts}/edit', ['as'=> 'admin.alerts.edit', 'uses' => 'AlertController@edit']);

        Route::get('admin/keys', ['as'=> 'admin.keys.index', 'uses' => 'KeyController@index']);
        Route::post('admin/keys', ['as'=> 'admin.keys.store', 'uses' => 'KeyController@store']);
        Route::get('admin/keys/create', ['as'=> 'admin.keys.create', 'uses' => 'KeyController@create']);
        Route::put('admin/keys/{keys}', ['as'=> 'admin.keys.update', 'uses' => 'KeyController@update']);
        Route::patch('admin/keys/{keys}', ['as'=> 'admin.keys.update', 'uses' => 'KeyController@update']);
        Route::delete('admin/keys/{keys}', ['as'=> 'admin.keys.destroy', 'uses' => 'KeyController@destroy']);
        Route::get('admin/keys/{keys}', ['as'=> 'admin.keys.show', 'uses' => 'KeyController@show']);
        Route::get('admin/keys/{keys}/edit', ['as'=> 'admin.keys.edit', 'uses' => 'KeyController@edit']);
    });
});
Route::post('admin/userlocations/{user}', ['as'=> 'admin.userlocations.store', 'uses' => 'UserLocationController@store']);
Route::get('ajaxSubCategory/{categoryId}', 'SubCategoriesController@ajaxGetSubCategories'); //retrieving sub-categories when clicking a category on the modal
Route::get('ajaxProducts/{subCategoryId}', 'ProductsController@ajaxGetProducts'); //retrieving products by search in the content body
Route::get('ajaxSearchProducts/{searchKeyWord}', 'ProductsController@ajaxSearchProductsKey');
//Route::get('ajaxScrollProducts/{subCategoryId}/{lastProductId}','ProductsController@ajaxScrollProducts');
//Route::group(['prefix' => 'all-products'], function () {
//    Route::get('{catgoryId}',['as' => 'products.all', 'uses' => 'RetrieveProductController@getProducts']);
//    Route::get('{productId}/details',['as' => 'product.details', 'uses' => 'RetrieveProductController@getDetails']);
//});

// Route::get('/', function()
// {
//     $img = Image::canvas(800, 600, '#ff0000');
//     $response = Response::make($img->encode('png'));
//     $response->header('Content-Type', 'image/png');
//     return $response
// });

// Route::get('/', function()
// {
//     $img = Image::canvas(800, 600, '#ff0000');

//     return $img->response();
// });

// Route::get('resize-image/{pathkey}/{filename}/{w?}/{h?}', function($pathkey, $filename, $w=100, $h=100){

//     $cacheimage = Image::cache(function($image) use($pathkey, $filename, $w, $h){

//         switch($pathkey){
//             case 'tour-images':
//                 $filepath = 'upload/tour-images/' . $filename;
//                 break;
//         }
//         return $image->make($filepath)->resize($w,$h);

//     },10); // cache for 10 minutes

//     return Response::make($cacheimage, 200, array('Content-Type' => 'image/jpeg'));
// });

//Route::get('/Gallery/thumb/{path}', function($path)
//{
//    $img_path = 'public/Gallery/'.$path;
//
//    $img = Image::make($img_path);
//    $img->resize(300, null, function ($constraint) {
//        $constraint->aspectRatio();
//    });
//    $img2path = 'public/Gallery/thumb/'.$path;
//    $img->save($img2path);
//    $response = Response::make($img->encode('jpg'));
//    $response->header('Content-Type', 'image/jpg');
//    return $response;
//});

Route::get('imagecache/{template}/{filename}', [
    'uses' => 'ImageCacheController@getResponse',
    'as'   => 'imagecache',
])->where('filename', '[ \w\\.\\/\\-\\@]+');
