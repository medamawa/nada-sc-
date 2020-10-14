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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/register/request', 'Auth\RegisterRequestController@index')->name('auth.register.request.index');
Route::post('/register/request', 'Auth\RegisterRequestController@post')->name('auth.register.request.post');
Route::post('/register/pre', 'Auth\RegisterController@register')->name('auth.register.pre');

Route::get('/register/verify', 'Auth\RegisterController@checkUser')->name('auth.register.checkUser');
Route::post('/register/verify', 'Auth\RegisterController@verify')->name('auth.register.verify');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ミドルウェアで認証済みでない(ログインしていない)ユーザーを弾く
Route::group(['middleware' => 'auth'], function () {
    Route::get('/me', 'UserController@index')->name('me');

    // ミドルウェアで管理者(admin)でないユーザーを弾く
    Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function () {
        Route::get('/', 'UserController@admin')->name('admin.home');
    });

    Route::prefix('/club')->group(function() {
        Route::get('/', 'ClubController@home')->name('club.home');

        Route::get('/create', 'ClubController@create')->name('club.create');
        Route::post('/create', 'ClubController@store')->name('club.store');

        Route::get('/join/request', 'ClubController@join_request')->name('club.join.request');
        Route::post('/join', 'ClubController@join')->name('club.join');

        // ミドルウェアで存在しないクラブ、所属していないユーザーを弾く
        Route::group(['prefix' => '/n/{name}', 'middleware' => 'check.club.isOk'], function() {
            Route::get('/', 'ClubController@n_home')->name('club.n.home');
            Route::get('/members', 'ClubController@members')->name('club.n.members');

            Route::get('/post', 'PostController@create')->name('club.n.post.create');
            Route::post('/post', 'PostController@store')->name('club.n.post.store');
            Route::get('/index', 'PostController@index')->name('club.n.index');

            Route::get('/leave/request', 'ClubControler@leave_request')->name('club.leave.request');
            Route::post('/leave', 'ClubController@leave')->name('club.leave');

            // ミドルウェアでクラブの管理者(admin)でないユーザーを弾く
            Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin.club'], function () {
                Route::get('/', 'ClubController@admin')->name('club.n.admin');
            });
        });
    });
});
