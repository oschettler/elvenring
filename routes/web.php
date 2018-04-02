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

// Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/passport', 'HomeController@passport')->name('passport');

    Route::get('/first', 'StoryController@first')->name('first');

    Route::resource('circle', 'CircleController');
    Route::resource('author', 'AuthorController');
    Route::resource('story', 'StoryController', ['except' => 'show']);

    Route::get('story/{story}/images', 'StoryController@images');

    Route::post('media/{media}/delete', 'MediaController@delete');
});

Route::get('/published', 'StoryController@published')->name('published');
Route::get('/story/{id}', 'StoryController@show')->name('story.show');
Route::get('/gh345kghj3425g56kjhg8ljk', 'Auth\\LoginController@aztest')->name('aztest');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/doc', function () {
    return view('doc');
})->name('doc');

