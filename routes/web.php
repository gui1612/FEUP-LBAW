<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

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

// OAuth
Route::get('/auth/{provider}/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

// Home
Route::get('/', 'FeedController@show')->name('feed.show');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.submit');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register.show');
Route::post('register', 'Auth\RegisterController@register')->name('register.submit');

// Password Reset
Route::get('forgot-password', 'Auth\PasswordResetController@showSendLinkForm')->name('showLinkForm');
Route::post('forgot-password', 'Auth\PasswordResetController@sendLink')->name('sendLink');
Route::get('reset', 'Auth\PasswordResetController@showResetPasswordForm')->name('password.reset');
Route::post('reset', 'Auth\PasswordResetController@reset')->name('password.update');

// Users
Route::get('users/{user}', 'UserController@show_user')->name('user.show');
Route::get('users/{user}/edit', 'UserController@showEditForm')->name('user.edit');
Route::delete('users/{user}', 'UserController@delete')->name('user.delete');
Route::put('user/{user}/edit', 'UserController@update')->name('editProfile')->where(['id' => '[0-9]+']);

// Administration
Route::get('admin/users', 'AdminController@show_users')->name('admin.users');
Route::get('admin/forums', 'AdminController@show_forums')->name('admin.forums');
Route::get('admin/team', 'AdminController@show_team')->name('admin.team');
Route::get('admin/reports', 'ReportsController@show_reports')->name('admin.reports');
Route::get('admin/reports/{report}', 'ReportsController@show_report')->name('admin.reports.report');
Route::put('admin/reports/{report}/ongoing', 'ReportsController@ongoing')->name('admin.reports.ongoing');
Route::put('admin/reports/{report}/approved', 'ReportsController@approved')->name('admin.reports.approved');
Route::put('admin/reports/{report}/denied', 'ReportsController@denied')->name('admin.reports.denied');
Route::post('admin/team/{user}', 'AdminController@promote')->name('admin.team.promote');
Route::delete('admin/team/{admin}', 'AdminController@demote')->name('admin.team.demote');
Route::post('admin/team/{user}/block', 'AdminController@block')->name('admin.team.block');
Route::post('admin/team/{user}/unblock', 'AdminController@unblock')->name('admin.team.unblock');

// Post
Route::post('forums/{forum}/posts/', 'PostController@create_post')->name('post.create_post');
Route::get('forums/{forum}/posts/new', 'PostController@show_create_post_form')->name('post.create');
Route::get('forums/{forum}/posts/{post}', 'PostController@show_post')->name('post');
Route::put('forums/{forum}/posts/{post}', 'PostController@edit_post')->name('post.edit_with_new_data');
Route::delete('forums/{forum}/posts/{post}', 'PostController@delete_post')->name('post.delete');
Route::get('forums/{forum}/posts/{post}/edit', 'PostController@show_edit_post_form')->name('post.edit');

// Post Comments
Route::post('posts/{post}/comments', 'PostCommentsController@create_comment')->name('post.comments.create');
Route::put('posts/{post}/comments/{comment}', 'PostCommentsController@edit_comment')->name('post.comments.edit');
Route::delete('posts/{post}/comments/{comment}', 'PostCommentsController@delete_comment')->name('post.comments.delete');
Route::post('api/comments/{comment}/rating', 'CommentRatingController@save')->name('comment.like');
Route::delete('api/comments/{comment}/rating', 'CommentRatingController@destroy')->name('comment.dislike');

// Post Images
Route::post('posts/{post}/images', 'PostImagesController@add_image')->name('post.images.add');
Route::delete('posts/{post}/images/{image}', 'PostImagesController@remove_image')->name('post.images.remove');
// Ratings API
Route::get('api/posts/{post}/rating', 'PostRatingController@show')->name('post.rating.get');
Route::post('api/posts/{post}/rating', 'PostRatingController@save')->name('post.rating.rate');
Route::delete('api/posts/{post}/rating', 'PostRatingController@destroy')->name('post.rating.remove');

// Static pages 
Route::get('about', 'StaticPagesController@showAboutPage')->name('about');
Route::get('contact', 'StaticPagesController@showContactPage')->name('contact');
Route::get('features', 'StaticPagesController@showFeaturesPage')->name('features');

// Follows
Route::post('/users/{user}/follow', 'UserFollowController@follow')->name('user.follow');
Route::delete('/users/{user}/unfollow', 'UserFollowController@unfollow')->name('user.unfollow');

// Notifications
Route::get('/notifications', 'NotificationController@show_all')->name('notifications.show_all');
Route::get('/notifications/{notification}', 'NotificationController@show_notification')->name('notifications.show_notification');
Route::post('/notifications/{notification}', 'NotificationController@mark_as_read')->name('mark_as_read');
Route::get('/api/notifications/navbar', 'NotificationController@navbar');

// Reports
Route::post('posts/{post}/report', 'ReportsController@post_report')->name('post.report.new');
Route::post('posts/{post}/comment/{comment}/report', 'ReportsController@comment_report')->name('comment.report.new');
Route::post('forum/{forum}/report', 'ReportsController@forum_report')->name('forum.report.new');
Route::post('/forums/{forum}/follow', 'ForumFollowController@follow')->name('forum.follow');
Route::delete('/forums/{forum}/unfollow', 'ForumFollowController@unfollow')->name('forum.unfollow');

//Forum Management
Route::get('/forums/{forum}/management', 'ForumOwnerController@show_forum_management')->name('forum.management');
Route::put('forums/{forum}/update', 'ForumController@update')->name('forum.update');

//Forums
Route::post('forums/', 'ForumController@create_forum')->name('forum.create_forum');
Route::get('/forums/new', 'ForumController@show_create_forum_form')->name('forum.create');
Route::get('/forums/{forum}', 'ForumController@show')->name('forum.show');
Route::delete('/forums/{forum}/delete', 'ForumController@delete')->name('forum.delete');

Route::middleware([])->group(function () {
  Route::post('/forums/{forum}/promote/{user}', 'ForumOwnerController@promote')->name('forum.management.promote');
  Route::delete('/forums/{forum}/demote/{user}', 'ForumOwnerController@demote')->name('forum.management.demote');
});

Route::get('/search', 'SearchController@search')->name('search');
