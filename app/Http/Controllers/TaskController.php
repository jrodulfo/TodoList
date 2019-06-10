<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Traits\Macroable;

/*
    Controller for task stuff

    User identify isn't expected in request parameters, it 
    is always retrived using the auth() helper
*/
class TaskController extends Controller
{
    // Get a list of tasks associated to a Todo List
    public function list($id)
    {
        $user = auth()->user();
        $returnData = array(['status' => 'error']);

        if ($user != null) {
            if ($id != null) {
                $ongoingTasks = Task::where('todolist_id', $id)
                    ->where('done', false)
                    ->orderBy('taskOrder', 'ASC')
                    ->get();

                $doneTasks = Task::where('todolist_id', $id)
                    ->where('done', true)
                    ->orderBy('taskOrder', 'ASC')
                    ->get();

                $returnData['status'] = 'success';
                $returnData['data'] = array(
                    [
                        'ongoing' => $ongoingTasks,
                        'done' => $doneTasks
                    ]
                );
            } else {
                $returnData['message'] = 'List id is required';
            }
            return response()->json($returnData);
        } else {
            $returnData['message'] = 'No user is logged or session has expired';
            $returnData['code'] = 'NOUSER';
        }
    }

    // Mark a task as done
    public function complete($id)
    {
        $user = auth()->user();
        $returnData = array(['status' => 'error']);

        if ($user != null) {
            if ($id != null) {
                Task::where('id', $id)->update(['done' => true]);
                $returnData['status'] = 'success';
            } else {
                $returnData['message'] = 'Task id is required';
            }
        } else {
            $returnData['message'] = 'No user is logged or session has expired';
            $returnData['code'] = 'NOUSER';
        }
        return response()->json($returnData);
    }

    // Delete a task
    public function delete($id)
    {
        $user = auth()->user();
        $returnData = array(['status' => 'error']);

        if ($user != null) {
            if ($id != null) {
                Task::find($id)->delete();
                $returnData['status'] = 'success';
            } else {
                $returnData['message'] = 'Task id is required';
            }
        } else {
            $returnData['message'] = 'No user is logged or session has expired';
            $returnData['code'] = 'NOUSER';
        }
        return response()->json($returnData);
    }

    // Create new task
    public function new(Request $request)
    {
        $user = auth()->user();
        $returnData = array(['status' => 'error']);

        if ($user != null) {
            $listId = $request->input("listId");
            $taskDescription = $request->input("taskDescription");

            if ($listId != null) {
                // first, look for the highest order in the list
                $maxTask = Task::where('todolist_id', $listId)
                    ->orderBy('taskOrder', 'desc')
                    ->first();

                $order = 0;
                if ($maxTask == null) {
                    $order = 0;
                } else {
                    $order = $maxTask->taskOrder + 1;
                }

                if (trim($taskDescription) != '') {
                    $task = new Task();
                    $task->description = $taskDescription;
                    $task->todolist_id = $listId;
                    $task->taskOrder = $order;
                    $task->done = false;
                    $task->save();
                }

                $returnData['status'] = 'success';
                $returnData['data'] = $task;
            } else {
                $returnData['message'] = 'List id is required';
            }
        } else {
            $returnData['message'] = 'No user is logged or session has expired';
            $returnData['code'] = 'NOUSER';
        }
        return response()->json($returnData);
    }

    // Update task name/description
    public function updateDescription(Request $request)
    {
        $user = auth()->user();
        $returnData = array(['status' => 'error']);

        if ($user != null) {
            $taskId = $request->input("taskId");
            $taskDescription = $request->input("taskDescription");

            if ($taskId != null) {
                if ($taskDescription != null) {
                    // first, look for the highest order in the list
                    $task = Task::where('id', $taskId)
                        ->update(['description' => $taskDescription]);

                    $returnData['status'] = 'success';
                    $returnData['data'] = $task;
                } else {
                    $returnData['message'] = 'Task description is required';
                }
            } else {
                $returnData['message'] = 'Task id is required';
            }
        } else {
            $returnData['message'] = 'No user is logged or session has expired';
            $returnData['code'] = 'NOUSER';
        }
        return response()->json($returnData);
    }

    // Exchanges order of 2 tasks
    public function exchangeOrder(Request $request)
    {
        $user = auth()->user();
        $returnData = array(['status' => 'error']);

        if ($user != null) {
            $taskId1 = $request->input("taskId1");
            $taskId2 = $request->input("taskId2");

            $task1 = Task::where("id", $taskId1)->first();
            $task2 = Task::where("id", $taskId2)->first();

            $order1 = $task1->taskOrder;
            $order2 = $task2->taskOrder;

            $task1->taskOrder = $order2;
            $task2->taskOrder = $order1;

            $task1->save();
            $task2->save();
            $returnData['status'] = "success";
        } else {
            $returnData['message'] = 'No user is logged or session has expired';
            $returnData['code'] = 'NOUSER';
        }
        return response()->json($returnData);
    }
}
