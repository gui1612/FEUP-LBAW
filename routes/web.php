<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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
// Home
Route::get('/', 'Auth\LoginController@home');

// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

Route::get('users/{id}', 'UserController@show')->name('user.show');

Route::get('admin/team', 'AdminController@show_team')->name('admin.team');
Route::post('admin/team/{id}', 'AdminController@promote')->name('admin.team.promote');
Route::delete('admin/team/{id}', 'AdminController@demote')->name('admin.team.demote');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('posts/{id}', 'PostController@show')->name('post');
Route::get('post/{id}/edit', 'PostController@edit')->name('post.edit');
Route::put('post/{id}/edit', 'PostController@edit_with_new_data')->name('post.edit');
Route::delete('api/post/{id}', 'PostController@delete');