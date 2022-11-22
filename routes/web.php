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
Route::get('/', 'FeedController@show_chronological')->name('feed');
Route::get('/home', 'FeedController@show_rated')->name('feed.rated');

// Cards
Route::get('cards', 'CardController@list')->name('user.settings');
Route::get('cards/{id}', 'CardController@show');

// Users
Route::get('users/{id}', 'UserController@show')->name('user.show');
Route::get('users/{id}/edit', 'UserController@edit')->name('user.edit');

Route::get('admin/team', 'AdminController@show_team')->name('admin.team');
Route::post('admin/team/{id}', 'AdminController@promote')->name('admin.team.promote');
Route::delete('admin/team/{id}', 'AdminController@demote')->name('admin.team.demote');

Route::get('admin/users', 'AdminController@show_users')->name('admin.users');
Route::delete('admin/users/{id}', 'AdminController@delete_user')->name('admin.user.delete');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login.show');
Route::post('login', 'Auth\LoginController@login')->name('login.submit');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register.show');
Route::post('register', 'Auth\RegisterController@register')->name('register.submit');

Route::get('post/{id}', 'PostController@show')->name('post');
Route::get('post/{id}/edit', 'PostController@edit')->name('post.edit');
Route::get('post/', 'PostController@create_post')->name('post.create');
Route::put('post/{id}/edit', 'PostController@edit_with_new_data');
Route::delete('api/post/{id}', 'PostController@delete')->name('post.delete');

Route::post('post/', 'PostController@create');