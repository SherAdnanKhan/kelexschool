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
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('forgot-password', 'AuthController@sendResetLinkEmail');
    Route::post('change-password', 'AuthController@changePassword');

    
    Route::middleware('auth:api')->group(function () {
        Route::group(['prefix' => 'art'], function () {
            Route::get('', 'ArtController@getAll');
            Route::post('', 'ArtController@store');
            Route::post('/user-art-selection', 'ArtController@userArtSection');
        });
        Route::group(['prefix' => 'my-studio'], function () {
            Route::get('/', 'StudioController@getMyStudio');
            Route::post('/avatar', 'StudioController@updateMyCubicImage');
        });

        Route::group(['prefix' => 'gallery'], function () {
            Route::get('my-galleries', 'GalleryController@getMyGalleries');
        });
    });

});

