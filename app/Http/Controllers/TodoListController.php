<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TodoList;
use App\Task;

class TodoListController extends Controller
{
    public function list()
    {
        $todoLists = TodoList::all();
        // Compact helps us to create an array
        return view('todolist.list')->with(compact('todoLists'));
    }

    public function new(Request $request)
    {
        //dd($request->all());
        if ($request->input('title') == null) {
            return view('todolist.new');
        } else {
            $todoList = new TodoList();
            $todoList->title = $request->input('title');
            $todoList->user_id = $request->input('userId');
            $todoList->save();

            // If the user captured tasks, save them
            $listId = $todoList->id;
            $tasks = $request->input('taskDescription');
            $order = 1;
            foreach ($tasks as $taskDescription) 
            {
                if (trim($taskDescription) != '') 
                {
                    $task = new Task();
                    $task->description = $taskDescription;
                    $task->todolist_id = $listId;
                    $task->order = $order++;
                    $task->done = false;
                    $task->save();
                }
            }
        }
        // Go to lists view
        $todoLists = TodoList::all();
        return view('todolist.list')->with(compact('todoLists'));
    }

    public function delete($id)
    {
        if ($id != null) {
            // First validate if record exits
            $todoList = TodoList::find($id);
            if ($todoList != null) 
            { 
                $todoList->delete();
                return response()->json(['status' => 'success', 'message' => 'Todo List successfully deleted']);
            }
            else
            {
                return response()->json(['status' => 'error', 'message' => 'Todo list not found']);
            }
        } 
        else 
        {
            return response()->json(['status' => 'error', 'message' => 'Todo list not found']);
        }
    }
}
