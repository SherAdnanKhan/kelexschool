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

        });
    });
});
