<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('test', 'Auth\AuthController@test')->name('test');
Route::post('login', 'Auth\AuthController@login')->name('login');
Route::post('signup', 'Auth\AuthController@signup')->name('signup');

Route::group(['middleware' => ['auth:api', 'rolepermission']], function () {
    //url routes
    Route::get('url', 'Url\UrlController@index')->name('url');
    Route::post('url', 'Url\UrlController@store')->name('url-store');
    Route::delete('url/{id}', 'Url\UrlController@delete')->name('url-delete');

    //role routes
    Route::get('role', 'Role\RoleController@index')->name('role');
    Route::post('role', 'Role\RoleController@store')->name('role-store');
    Route::delete('role/{id}', 'Role\RoleController@delete')->name('role-delete');

    //url-role routes
    Route::get('url-role', 'UrlToRole\UrlToRoleController@index')->name('url-role');
    Route::post('url-role', 'UrlToRole\UrlToRoleController@store')->name('url-role-store');
    Route::delete('url-role/{id}', 'UrlToRole\UrlToRoleController@delete')->name('url-role-delete');

    //role-user routes
    Route::get('role-user', 'RoleToUser\RoleToUserController@index')->name('role-user');
    Route::post('role-user', 'RoleToUser\RoleToUserController@store')->name('role-user-store');
    Route::delete('role-user/{id}', 'RoleToUser\RoleToUserController@delete')->name('role-user-delete');

    //post routes
    Route::get('all-post', 'Post\PostController@index')->name('all-post');
    Route::post('all-post', 'Post\PostController@store')->name('all-post-store');
    Route::delete('all-post/{id}', 'Post\PostController@delete')->name('all-post-delete');
});
