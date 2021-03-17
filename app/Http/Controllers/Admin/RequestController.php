<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request as Req;
use App\Models\Task;
use App\Http\Resources\requestResource;
use App\Http\Resources\taskResource;
use App\Events\updatedTask;


class RequestController extends Controller
{
    public function index($id)
    {
        try {
            $task=Task::findOrFail($id);
            return requestResource::collection($task->requests()->get());
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }

    public function accept($id)
    {
        try {
            $request=Req::findOrFail($id);
            $task=Req::findOrFail($id)->task;
            if(!$task->requests()->where('status',true)->count()){
                $request->update([
                    'status' => true
                ]);
                $task->progress=\App\Http\Enums\TaskStatus::INPROGRESS;
                $task->save();
                $task=new taskResource($task);
                event(new updatedTask($task));
                return new taskResource($task);
            }
            else{
                return response()->json(false, 400);
            }
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }
}
