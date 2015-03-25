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

Route::get('admin/image', 'AdminController@addImage');
Route::get('tag/{tag}/admin', 'AdminController@tag');
Route::get('tag/{tag}/api', 'AdminController@tagApi');

Route::get('tag/{tag}', 'ImagesController@tag');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

