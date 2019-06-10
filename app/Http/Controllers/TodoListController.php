<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TodoList;

/* 
    List related stuff controller
    
    User identify isn't expected in request parameters, it 
    is always retrived using the auth() helper
*/
class TodoListController extends Controller
{
    // Returns the main view, with the current lists that the user has
    public function list()
    {
        $user = auth()->user();

        if ($user != null) {
            $todoLists = TodoList::where('user_id', $user->id)->get();
            // Compact helps us to create an array
            return view('todolist.list')->with(compact('todoLists'));
        } else {
            return view('nouser');
        }
    }

    // Creates a new Todo List
    public function new(Request $request)
    {
        $user = auth()->user();
        $returnData = array(['status' => 'error']);

        if ($user != null) {
            if ($request->input('title') == null) {
                return view('todolist.new');
            } else {
                $todoList = new TodoList();
                $todoList->title = $request->input('title');
                $todoList->user_id = $user->id;
                $todoList->save();
            }
            $returnData['status'] = 'success';
        } else {
            $returnData['message'] = 'No user is logged or session has expired';
            $returnData['code'] = 'NOUSER';
        }

        return response()->json($returnData);
    }

    // Deletes a Todo List
    public function delete($id)
    {
        $user = auth()->user();

        if ($user != null) {
            if ($id != null) {
                // First validate if record exits
                $todoList = TodoList::find($id);
                if ($todoList != null) {
                    $todoList->delete();
                    return response()->json(['status' => 'success', 'message' => 'Todo List successfully deleted']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Todo list not found']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Todo list not found']);
            }
        } else {
            return view('nouser');
        }
    }
}
