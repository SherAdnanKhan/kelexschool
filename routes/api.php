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
                Route::group(['prefix' => 'chats'], function () {
                    Route::get('/user/{slug}', 'ChatController@create');
                    Route::get('/', 'ChatController@index');
                    Route::post('/message', 'ChatController@store');
                    Route::post('/message/read/{message_id}', 'ChatController@readMessage');
                    Route::post('/message/uploads', 'ChatController@uploadOnChat');
                    Route::get('/conversation/{id}', 'ChatController@show');
                });
                Route::group(['prefix' => 'comments'], function () {
                    Route::post('/', 'CommentController@store');
                    Route::get('/{post_id}', 'CommentController@index');
                });
                Route::group(['prefix' => 'favs'], function () {
                    Route::post('/', 'FavController@store');
                    Route::delete('/fave/{id}', 'FavController@destroy');
                    Route::get('/get-faved-by', 'FavController@faveBy');
                    Route::get('/get-faves', 'FavController@favs');
                    Route::get('/fav-counts', 'FavController@favCounts');
                });
                Route::group(['prefix' => 'galleries'], function () {
                    Route::get('my-gallery', 'GalleryController@getMyGalleries');
                    Route::post('my-gallery/create', 'GalleryController@store');
                    Route::post('my-gallery/update/{gallery_id}', 'GalleryController@update');
                    Route::delete('my-gallery/delete-image/{gallery_id}', 'GalleryController@deleteImage');
                    Route::get('/{slug}', 'GalleryController@show');
                    Route::post('/fav', 'GalleryController@make_fav');
                    Route::post('/unfav', 'GalleryController@make_unfav');
                    Route::get('/recommended/galleries', 'GalleryController@recommendedGalleries');
                });
                Route::group(['prefix' => 'lobby'], function () {
                    Route::get('/', 'LobbyController@index');
                });
                Route::group(['prefix' => 'my-studio'], function () {
                    Route::get('/', 'StudioController@getMyStudio');
                    Route::post('avatar', 'StudioController@updateMyCubicImage');
                    Route::Delete('avatar/{id}', 'StudioController@deleteMyCubicImage');
                });
                Route::group(['prefix' => 'mzflash'], function () {
                    Route::get('/', 'MzFlashController@index');
                    Route::get('/{user_id}', 'MzFlashController@index');
                    Route::post('/', 'MzFlashController@store');
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
                    Route::get('list-feels', 'UserController@getAllUserFeel');
                    Route::put('feel-color', 'UserController@updateUserFeel');
                    Route::put('user-bio', 'UserController@updateUserBio');
                    Route::get('unread-message-count', 'ChatController@unreadCount');
                });
                Route::group(['prefix' => 'user/privacy'], function () {
                    Route::get('/', 'PrivacyController@index');
                    Route::post('/', 'PrivacyController@store');
                    Route::get('/lists/{privacy_type_id}/{status}', 'PrivacyController@getFaveList');
                    Route::post('/sprfvs', 'PrivacyController@addUserToSprfvs');
                    Route::post('/sprfvs/approved', 'PrivacyController@approveSprfvs');
                    Route::post('/sprfvs/reject', 'PrivacyController@rejectSprfvs');
                    Route::post('/invite-only', 'PrivacyController@addUserToInviteOnly');
                });

            });
        });
    });
    


});

