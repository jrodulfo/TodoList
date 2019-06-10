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
    return redirect('/todolist/list');
});

Auth::routes();

Route::get('/todolist/list', 'TodoListController@list');
Route::post('/todolist/list/new', 'TodoListController@new');
Route::post('/todolist/edit', 'TodoListController@edit');
Route::post('/todolist/delete/{id}', 'TodoListController@delete');

Route::get('/todolist/tasks/{id}', 'TaskController@list');
Route::post('/todolist/tasks/complete/{id}', 'TaskController@complete');
Route::post('/todolist/tasks/delete/{id}', 'TaskController@delete');
Route::post('/todolist/tasks/add', 'TaskController@new');
Route::post('/todolist/tasks/updateDescription', 'TaskController@updateDescription');
Route::post('/todolist/tasks/exchangeOrder', 'TaskController@exchangeOrder');

Route::post('/user/drop', 'UserController@drop');
