<?php

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

Route::get('/', function () {
    return view('welcome_static');
});

Route::namespace('Admin')->group(function () {
    Route::group(['prefix' => 'admin'], function () { 
        Route::get('/', function() {
            return redirect('admin/login');
        });

        Route::namespace('Auth')->group(function () {
            Route::get('/login', 'LoginController@showLogin')->name('admin.login');
            Route::post('/login', 'LoginController@login');
            Route::post('/logout', 'LoginController@logout')->name('admin.logout');
        });
        
        Route::group(['middleware' => 'auth:admin'], function () {
            
            Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
            
            Route::group(['prefix' => 'users'], function () {
                Route::get('/', 'UserController@index');
                Route::get('/get-data', 'UserController@getUserData');                
            });
            Route::group(['prefix' => 'user'], function () {
                Route::get('/{user_slug}', 'UserController@show');
            });

            Route::group(['prefix' => 'feels'], function () {
                Route::get('/', 'FeelController@index');
                Route::post('/', 'FeelController@create');
                Route::get('view/{id}', 'FeelController@show');
                Route::post('update/{id}', 'FeelController@update');
            });

            Route::group(['prefix' => 'feedbacks'], function () {
                Route::get('/', 'FeedbackController@index');
                Route::get('/get-data', 'FeedbackController@getFeedbackData');                
            });
            Route::group(['prefix' => 'feedback'], function () {
                Route::get('/{user_slug}', 'FeedbackController@show');
            });

            Route::group(['prefix' => 'user-reports'], function () {
                Route::get('/', 'ReportController@index');
                Route::get('/get-data', 'ReportController@getReportUserData');                
            });
            Route::group(['prefix' => 'report'], function () {
                Route::get('/ban-user/{user_slug}{id}', 'ReportController@banUser');
                Route::get('/delete-report/{id}', 'ReportController@deleteReport');
            });

            Route::group(['prefix' => 'post-reports'], function () {
                Route::get('/', 'ReportController@indexPost');
                Route::get('/get-data', 'ReportController@getReportPostData');                
            });
            Route::group(['prefix' => 'post-report'], function () {
                Route::get('/view-post/{slug}', 'ReportController@viewPost');
                Route::get('/delete-post/{slug}', 'ReportController@removePost');
                Route::get('/delete-report/{slug}', 'ReportController@deletePostReport');
            });

        });
    });
});
