<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::get('/', 'HomeController@index');

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

// Route::resource('user', 'UserController')->middleware('auth');

Route::resource('post', 'PostController')->middleware('auth');
