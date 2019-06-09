<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/todolist/list', 'TodoListController@list');
Route::post('/todolist/new', 'TodoListController@new');
Route::post('/todolist/edit', 'TodoListController@edit');
Route::post('/todolist/delete/{id}', 'TodoListController@delete');

// Ajax routes
