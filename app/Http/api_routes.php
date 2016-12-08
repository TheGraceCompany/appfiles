<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
 */

Route::get('dealers', 'DealerAPIController@index');
Route::post('dealers', 'DealerAPIController@store');
Route::get('dealers/{dealers}', 'DealerAPIController@show');
Route::put('dealers/{dealers}', 'DealerAPIController@update');
Route::patch('dealers/{dealers}', 'DealerAPIController@update');
Route::delete('dealers{dealers}', 'DealerAPIController@destroy');

Route::get('locations', 'LocationAPIController@index');
Route::post('locations', 'LocationAPIController@store');
Route::get('locations/{locations}', 'LocationAPIController@show');
Route::put('locations/{locations}', 'LocationAPIController@update');
Route::patch('locations/{locations}', 'LocationAPIController@update');
Route::delete('locations{locations}', 'LocationAPIController@destroy');

Route::get('sections', 'SectionAPIController@index');
Route::post('sections', 'SectionAPIController@store');
Route::get('sections/{sections}', 'SectionAPIController@show');
Route::put('sections/{sections}', 'SectionAPIController@update');
Route::patch('sections/{sections}', 'SectionAPIController@update');
Route::delete('sections{sections}', 'SectionAPIController@destroy');

Route::get('keys', 'KeyAPIController@index');
Route::post('keys', 'KeyAPIController@store');
Route::get('keys/{keys}', 'KeyAPIController@show');
Route::put('keys/{keys}', 'KeyAPIController@update');
Route::patch('keys/{keys}', 'KeyAPIController@update');
Route::delete('keys{keys}', 'KeyAPIController@destroy');

Route::get('alerts', 'AlertAPIController@index');
Route::post('alerts', 'AlertAPIController@store');
Route::get('alerts/{alerts}', 'AlertAPIController@show');
Route::put('alerts/{alerts}', 'AlertAPIController@update');
Route::patch('alerts/{alerts}', 'AlertAPIController@update');
Route::delete('alerts{alerts}', 'AlertAPIController@destroy');

Route::get('categories', 'CategoryAPIController@index');
Route::post('categories', 'CategoryAPIController@store');
Route::get('categories/{categories}', 'CategoryAPIController@show');
Route::put('categories/{categories}', 'CategoryAPIController@update');
Route::patch('categories/{categories}', 'CategoryAPIController@update');
Route::delete('categories{categories}', 'CategoryAPIController@destroy');

Route::get('users', 'UserAPIController@index');
Route::post('users', 'UserAPIController@store');
Route::get('users/{users}', 'UserAPIController@show');
Route::put('users/{users}', 'UserAPIController@update');
Route::patch('users/{users}', 'UserAPIController@update');
Route::delete('users{users}', 'UserAPIController@destroy');

Route::get('products', 'ProductAPIController@index');
Route::post('products', 'ProductAPIController@store');
Route::get('products/{products}', 'ProductAPIController@show');
Route::put('products/{products}', 'ProductAPIController@update');
Route::patch('products/{products}', 'ProductAPIController@update');
Route::delete('products{products}', 'ProductAPIController@destroy');

Route::get('faqs', 'FaqAPIController@index');
Route::post('faqs', 'FaqAPIController@store');
Route::get('faqs/{faqs}', 'FaqAPIController@show');
Route::put('faqs/{faqs}', 'FaqAPIController@update');
Route::patch('faqs/{faqs}', 'FaqAPIController@update');
Route::delete('faqs{faqs}', 'FaqAPIController@destroy');

Route::get('boxes', 'BoxAPIController@index');
Route::post('boxes', 'BoxAPIController@store');
Route::get('boxes/{boxes}', 'BoxAPIController@show');
Route::put('boxes/{boxes}', 'BoxAPIController@update');
Route::patch('boxes/{boxes}', 'BoxAPIController@update');
Route::delete('boxes{boxes}', 'BoxAPIController@destroy');

Route::get('sections', 'SectionAPIController@index');
Route::post('sections', 'SectionAPIController@store');
Route::get('sections/{sections}', 'SectionAPIController@show');
Route::put('sections/{sections}', 'SectionAPIController@update');
Route::patch('sections/{sections}', 'SectionAPIController@update');
Route::delete('sections{sections}', 'SectionAPIController@destroy');

Route::get('shippingmethods', 'ShippingmethodAPIController@index');
Route::post('shippingmethods', 'ShippingmethodAPIController@store');
Route::get('shippingmethods/{shippingmethods}', 'ShippingmethodAPIController@show');
Route::put('shippingmethods/{shippingmethods}', 'ShippingmethodAPIController@update');
Route::patch('shippingmethods/{shippingmethods}', 'ShippingmethodAPIController@update');
Route::delete('shippingmethods{shippingmethods}', 'ShippingmethodAPIController@destroy');
