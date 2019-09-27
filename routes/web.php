<?php

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/categories', 'HomeController@categoriesPage')->name('categories');
Route::get('/channels', 'HomeController@channelsPage')->name('channels');
Route::get('/about', 'HomeController@about')->name('about');

Route::delete('/musics/{id}', 'HomeController@deleteMusic')->middleware('auth');


Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

Auth::routes([
    'register' => false,    // Registration Routes...
    'reset' => false,       // Password Reset Routes...
    'verify' => false,      // Email Verification Routes...
]);