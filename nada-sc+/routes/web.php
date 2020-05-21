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

Route::get('/register-request', 'Auth\RegisterRequestController@index')->name('auth.register.request.index');
Route::post('/register-request', 'Auth\RegisterRequestController@post')->name('auth.register.request.post');
Route::post('/register/pre_check', 'Auth\RegisterController@register')->name('auth.register.pre_check');
Route::get('/register/verify', 'Auth\RegisterController@verify');
