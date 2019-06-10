<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
    Model class for Todo List
*/
class TodoList extends Model
{
    protected $table = 'todo_lists';
    protected $primaryKey = 'id';
    
}
