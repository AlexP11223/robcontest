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

Route::get('/', 'HomeController@index');

Route::get('info', function() {
    return view('info');
});

Route::resource('posts', 'PostsController', ['except' => 'index']);

Route::get('admin-login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin-login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('change-password', 'UserController@showChangePasswordForm')->name('change-password');
Route::post('change-password', 'UserController@changePassword');

