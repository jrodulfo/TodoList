<?php
Route::get('/', function () {
    return redirect('/todolist/list');
});
// Set routes for authentication
Auth::routes();
// Routes for list operations
Route::get('/todolist/list', 'TodoListController@list');
Route::post('/todolist/list/new', 'TodoListController@new');
Route::post('/todolist/edit', 'TodoListController@edit');
Route::post('/todolist/delete/{id}', 'TodoListController@delete');
// Routes for task operations
Route::get('/todolist/tasks/{id}', 'TaskController@list');
Route::post('/todolist/tasks/complete/{id}', 'TaskController@complete');
Route::post('/todolist/tasks/delete/{id}', 'TaskController@delete');
Route::post('/todolist/tasks/add', 'TaskController@new');
Route::post('/todolist/tasks/updateDescription', 'TaskController@updateDescription');
Route::post('/todolist/tasks/exchangeOrder', 'TaskController@exchangeOrder');
// Routes for user operations
Route::post('/user/drop', 'UserController@drop');
