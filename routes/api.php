<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::get('/tags', 'TagController@getAll');
Route::get('/notes', 'NoteController@getAll');
Route::get('/notes/root', 'NoteController@getRoot');
Route::get('/notes/{id}', 'NoteController@getById');
Route::get('/notes/{id}/childrens', 'NoteController@getChildrens');
Route::get('/notes/{id}/tree', 'NoteController@getParentTree');

Route::get('/search/notes', 'NoteController@search');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/tags', 'TagController@add');
    Route::delete('/tags/{id}', 'TagController@remove');
    
    Route::post('/notes', 'NoteController@add');
    Route::put('/notes/{id}', 'NoteController@update');
    Route::delete('/notes/{id}', 'NoteController@remove');
});