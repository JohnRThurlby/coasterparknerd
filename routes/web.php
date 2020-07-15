<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/about', 'AboutController@index')->name('about');

Route::get('/privacy', 'PrivacyController@index')->name('privacy');

Route::get('/terms', 'TermsController@index')->name('terms');

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){

  Route::get('/home', 'HomeController@index')->name('home');

 // Parks

  Route::get('/parks', 'ParksController@index')->name('parks');


  Route::get('/park/create', 'ParksController@create')->name('park.create');

  //Route::post('/post/store', 'PostsController@store')->name('post.store');

  Route::get('/park/edit/{id}', 'ParksController@edit')->name('park.edit');

  Route::post('/park/update/{id}', 'ParksController@update')->name('park.update');

  Route::get('/park/delete/{id}', 'ParksController@destroy')->name('park.delete');


  // Rides

  Route::get('/parkrides', 'RidesController@index')->name('parkrides');

  Route::get('/parkride/create', 'RidesController@create')->name('parkride.create');

  Route::post('/parkride/store', 'RidesController@store')->name('parkride.store');

  Route::get('/parkride/edit/{id}', 'RidesController@edit')->name('parkride.edit');

  Route::post('/parkride/update/{id}', 'RidesController@update')->name('parkride.update');

  Route::get('/parkride/delete/{id}', 'RidesController@destroy')->name('parkride.delete');

});
