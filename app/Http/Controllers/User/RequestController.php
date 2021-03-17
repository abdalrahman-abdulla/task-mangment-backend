<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\User;
use App\Events\updatedTask;
use App\Http\Resources\taskResource;
class RequestController extends Controller
{
    public function store($id)
    {
        try {
            $task=Task::findOrFail($id);
            if($task->requests->where('user_id',auth()->user()->id)->count())
            {
                return  response()->json(false, 500);
            }
            else{
                $task->requests()->create([
                    'status' => 0,
                    'user_id' => auth()->user()->id,
                ]);
                $task=new taskResource($task);
                event(new updatedTask($task));
                return response()->json($task, 200);
            }
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }


    }
}
