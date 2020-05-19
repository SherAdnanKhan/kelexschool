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

Route::namespace('API')->group(function () {
    Route::namespace('v1')->group( function () {
        Route::group(['prefix' => 'v1'], function () { 
            Route::group(['prefix' => 'auth'], function () {
                Route::post('register', 'AuthController@register'); 
                Route::post('login', 'AuthController@login');
                Route::post('forgot-password', 'AuthController@sendResetLinkEmail');
                Route::post('change-password', 'AuthController@changePassword');
            });
            Route::middleware('auth:api')->group(function () {
                Route::group(['prefix' => 'arts'], function () {
                    Route::get('/', 'ArtController@getAll');
                    Route::post('/', 'ArtController@store');
                    Route::post('user-art-selection', 'ArtController@userArtSection');
                    Route::get('/art/{id}', 'ArtController@show');
                    Route::get('search', 'ArtController@searchArt');
                });
                Route::group(['prefix' => 'comments'], function () {
                    Route::post('/', 'CommentController@store');
                    Route::get('/{post_id}', 'CommentController@show');
                });
                Route::group(['prefix' => 'favs'], function () {
                    Route::post('/', 'FavController@store');
                    Route::delete('/{id}', 'FavController@destroy');
                    Route::get('/get-faved-by', 'FavController@fav_by');
                    Route::get('/get-faves', 'FavController@favs');
                    Route::get('/fav-counts', 'FavController@favCounts');
                });
                Route::group(['prefix' => 'galleries'], function () {
                    Route::get('my-gallery', 'GalleryController@getMyGalleries');
                    Route::get('/{slug}', 'GalleryController@show');
                    Route::post('/fav', 'GalleryController@make_fav');
                    Route::post('/unfav', 'GalleryController@make_unfav');
                });
                Route::group(['prefix' => 'lobby'], function () {
                    Route::get('/', 'LobbyController@index');
                });
                Route::group(['prefix' => 'my-studio'], function () {
                    Route::get('/', 'StudioController@getMyStudio');
                    Route::post('avatar', 'StudioController@updateMyCubicImage');
                    Route::Delete('avatar/{id}', 'StudioController@deleteMyCubicImage');
                });
                Route::group(['prefix' => 'post'], function () {
                    Route::post('/stroke', 'PostController@makeStroke');
                    Route::post('/unstroke', 'PostController@unStroke');
                });
                Route::group(['prefix' => 'posts'], function () {
                    Route::post('/', 'PostController@store');
                    Route::get('/{slug}', 'PostController@show');
                });
                Route::group(['prefix' => 'studios'], function () {
                    Route::get('/{slug}', 'StudioController@getUserStudio');
                });
                Route::group(['prefix' => 'users'], function () {
                    Route::get('/', 'UserController@getAllUsers');
                    Route::get('search', 'UserController@searchUsers');
                    Route::put('feel-color', 'UserController@updateUserFeel');
                });
            });
        });
    });
    


});

