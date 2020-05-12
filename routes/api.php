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
                    Route::get('search', 'ArtController@searchArt');
                });
                Route::group(['prefix' => 'my-studio'], function () {
                    Route::get('/', 'StudioController@getMyStudio');
                    Route::post('avatar', 'StudioController@updateMyCubicImage');
                });
                Route::group(['prefix' => 'galleries'], function () {
                    Route::get('my-gallery', 'GalleryController@getMyGalleries');
                });
                Route::group(['prefix' => 'posts'], function () {
                    Route::post('/', 'PostController@store');
                });
                Route::group(['prefix' => 'lobby'], function () {
                    Route::get('/', 'LobbyController@index');
                });
                Route::group(['prefix' => 'favs'], function () {
                    Route::get('/get-faves', 'FavController@favs');
                    Route::get('/fav-counts', 'FavController@favCounts');
                    Route::post('/', 'FavController@store');
                });
                Route::group(['prefix' => 'users'], function () {
                    Route::get('/', 'UserController@getAllUsers');
                });
            });
        });
    });
    


});

