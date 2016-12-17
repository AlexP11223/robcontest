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

Route::resource('contests', 'ContestsController');
Route::get('contests/{contest}/teams', 'ContestsController@indexTeams');
Route::get('contests/{contest}/obstacles', 'ContestsController@indexObstacles');
Route::get('contests/{contest}/sumo', 'ContestsController@indexSumo');

Route::get('apply', 'TeamsController@create')->name('apply');
Route::post('apply', 'TeamsController@store');
Route::get('contests/{contest}/review-teams', 'TeamsController@reviewTeams')->name('review-teams');
Route::patch('teams/{team}/{status}', 'TeamsController@setStatus')->where('status', 'approve|deny');

Route::patch('contests/{contest}/start', 'ContestsController@start')->name('start-contest');

Route::put('obstacles/{obstaclesGame}/time', 'ObstaclesController@setScore')->name('set-obstacles-result');

Route::get('admin-login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin-login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('change-password', 'UserController@showChangePasswordForm')->name('change-password');
Route::post('change-password', 'UserController@changePassword');

