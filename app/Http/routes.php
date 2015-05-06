<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::resource('/', 'SpotifyController');
Route::get('/spotify/auth', 'SpotifyController@authorize');
Route::get('/spotify/playlists', ['as' => 'spotify-playlists', 'uses' => 'SpotifyController@getPlaylists']);

Route::get('home', 'HomeController@index');

Route::get('spotify/callback', 'SpotifyController@callback');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
