<?php

namespace App\Http\Controllers;

use App\Task;

class TaskController extends Controller
{
    public function list($id)
    {
        $user = auth()->user();

        if ($user != null) {
            $returnData = array();

            if ($id != null) {
                $taskList = Task::find($id);

                if (empty($taskList)) {
                    $returnData['status'] = 'success';
                } else {
                    $returnData['status'] = 'success';
                    $returnData['data'] = $taskList;
                }
            }
            return response()->json($returnData);
        } else {
            return view('nouser');
        }
    }
}
