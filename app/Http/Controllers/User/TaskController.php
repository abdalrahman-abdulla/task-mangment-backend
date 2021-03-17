<?php

namespace App\Http\Controllers\User;
use App\Models\Task;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\taskResource;
use App\Http\Resources\commentResource;
use App\User;
use App\Http\Resources\tasksResource;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $department=Department::findOrFail(auth()->user()->department_id);
            $tasks=$department->tasks()->paginate(3);
            $pageInfo=[
                'total' => $tasks->total(),
                'per_page' => 3,
            ];
            $tasks=tasksResource::collection($tasks);
            $tasks=[
                'data' => $tasks,
                'page_info' =>$pageInfo
            ];
            return response()->json($tasks,200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }

    public function show($id)
    {
        try {
            return response()->json(new taskResource(Task::findOrFail($id)),200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }

    public function update(Request $req,$id)
    {
        try {
            $this->validate($req , [
                'progress'=>'required|numeric|in:1,2',
                'link' => 'required'
            ]);
            $task=Task::findOrFail($id);
            $task->update([
                'progress' => $req['progress'] ==2 ? \App\Http\Enums\TaskStatus::REVIEWING:\App\Http\Enums\TaskStatus::INPROGRESS,
                'link' => $req['link'] ]);
            return response()->json(new taskResource($task),200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }
}
