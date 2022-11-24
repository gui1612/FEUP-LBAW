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
Route::get('/', 'FeedController@show')->name('feed.show');

Route::get('users/{user}', 'UserController@show')->name('user.show');

// Route::middleware('auth')
Route::get('admin/users', 'AdminController@show_users')->name('admin.users');
Route::get('admin/team', 'AdminController@show_team')->name('admin.team');
Route::post('admin/team', 'AdminController@promote')->name('admin.team.promote');
Route::delete('admin/team/{admin}', 'AdminController@demote')->name('admin.team.demote');
// Route::delete('admin/users/{id}', 'AdminController@delete_user')->name('admin.user.delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.submit');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register.show');
Route::post('register', 'Auth\RegisterController@register')->name('register.submit');

// Post
Route::post('posts/', 'PostController@create_post')->name('post.create_post');
Route::get('posts/new', 'PostController@show_create_post_form')->name('post.create');
Route::get('posts/{post}', 'PostController@show_post')->name('post');
Route::patch('posts/{post}', 'PostController@edit_post')->name('post.edit_with_new_data');
Route::delete('posts/{post}', 'PostController@delete_post')->name('post.delete');
Route::get('posts/{post}/edit', 'PostController@show_edit_post_form')->name('post.edit');

// Post Images
Route::put('posts/{post}/images', 'PostImagesController@add_image');
Route::delete('posts/{post}/images/{images}', 'PostImagesController@delete_image');

// Ratings API
Route::get('api/posts/{post}/rating', 'PostRatingController@show')->name('post.rating.get');
Route::post('api/posts/{post}/rating', 'PostRatingController@save')->name('post.rating.rate');
Route::delete('api/posts/{post}/rating', 'PostRatingController@destroy')->name('post.rating.remove');