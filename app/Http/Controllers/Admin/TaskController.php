<?php

namespace App\Http\Controllers\Admin;
use App\Events\newTask;
use App\Events\deletedTask;
use App\Events\deletedShowTask;
use App\Events\updatedTask;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Request as Req;
use App\Http\Resources\taskResource;
use App\Http\Resources\tasksResource;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks=Task::paginate(3);
            $pageInfo=[
                'total' => $tasks->total(),
                'per_page' => 3,
            ];
            $tasks=tasksResource::collection($tasks);
            $tasks=[
                'data' => $tasks,
                'page_info' =>$pageInfo
            ];
            return response()->json($tasks, 200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }
    public function show($id)
    {
        try {
            return new taskResource(Task::findOrFail($id));
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }
    public function store(TaskRequest $req)
    {
        try {
            $task=Task::create([
                'title'=> $req['title'],
                'description'=> $req['description'],
                'department_id'=> $req['department_id'],
                'start_date'=> $req['start_date'],
                'deadline'=> $req['deadline'],
                'budget'=> $req['budget'],
                'requirements'=> implode(",",$req['requirements']),
                'resources'=> $req['resources'] ? implode(",",$req['resources']) : '',
            ]);
            event(new newTask(new taskResource($task->refresh())));
            return response()->json('added suucessfuly', 200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }

    public function update(TaskRequest $req,$id)
    {
        try {
            $task=Task::findOrFail($id);
            $task->update([
                'title'=> $req['title'],
                'description'=> $req['description'],
                'department_id'=> $req['department_id'],
                'start_date'=> $req['start_date'],
                'deadline'=> $req['deadline'],
                'budget'=> $req['budget'],
                'requirements'=> implode(",",$req['requirements']),
                'resources'=> $req['resources'] ? implode(",",$req['resources']) : '',
            ]);
            event(new updatedTask(new taskResource($task->refresh())));
            return response()->json('updated suucessfuly', 200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $task=Task::findOrFail($id);
            $copy=[
                'id'=>$task->id,
                'department_id'=>$task->department_id
            ];
            event(new deletedTask($copy));
            event(new deletedShowTask($copy));
            $task->delete();
            return response()->json('done', 200);
        }
        catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }

    public function approve($id)
    {
        try {
            $task=Task::findOrFail($id);
            if($task->progress==\App\Http\Enums\TaskStatus::REVIEWING){
                $task->progress=\App\Http\Enums\TaskStatus::DONE;
                $task->save();
                $task=new taskResource($task);
                event(new updatedTask($task));
                return $task;
            } else {
                return response()->json(false, 400);
            }
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }

}
