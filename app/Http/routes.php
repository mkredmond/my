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

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

Route::get('home', 'HomeController@index');

Route::get('admin', 'Admin\AdminController@index');

Route::resource('admin/users', 'Admin\UserController', [
    'parameters' => ['users' => 'user'],
    'except'     => ['edit'],
]);
