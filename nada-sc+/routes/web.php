<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/register/request', 'Auth\RegisterRequestController@index')->name('auth.register.request.index');
Route::post('/register/request', 'Auth\RegisterRequestController@post')->name('auth.register.request.post');
Route::post('/register/pre', 'Auth\RegisterController@register')->name('auth.register.pre');

Route::get('/register/verify', 'Auth\RegisterController@checkUser')->name('auth.register.checkUser');
Route::post('/register/verify', 'Auth\RegisterController@verify')->name('auth.register.verify');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/me', 'UserController@index')->name('me');

    Route::prefix('/club')->group(function() {
        Route::get('/create', 'ClubController@create')->name('club.create');
        Route::post('/create', 'ClubController@store')->name('club.store');

        Route::get('/join', 'ClubController@join')->name('club.join');

        Route::prefix('/n/{name}')->group(function() {  // {name}が存在するか確認するミドルウェアを実装
            Route::get('/', 'ClubController@home')->name('club.n.home');
            Route::get('/members', 'ClubController@members')->name('club.n.members');
            Route::get('/admin', 'ClubController@admin')->name('club.n.admin');    // adminのミドルウェアを実装

            Route::get('/post', 'PostController@create')->name('club.n.post.create');
            Route::post('/post', 'PostController@store')->name('club.n.post.store');
            Route::get('/index', 'PostController@index')->name('club.n.index');
        });
    });
});
