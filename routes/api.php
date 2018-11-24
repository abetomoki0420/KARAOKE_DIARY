<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('users/{uid}/categories' , 'UserController@showCategories');
Route::resource('users' , 'UserController');
Route::resource('karaokes' , 'KaraokeController');
Route::resource('artists' , 'ArtistController');
Route::get('songs/{id}/URL' , 'SongController@showURL');
Route::post('songs/updateURL' , 'SongController@updateURL');
Route::resource('songs' , 'SongController');
Route::resource('song_details' , 'SongDetailController');
Route::get('categories/{id}/songs' , 'CategoryController@showSongsHaveCategory');
Route::resource('categories' , 'CategoryController');
