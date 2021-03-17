<?php

namespace App\Http\Controllers\User;
use App\Models\Comment;
use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\updatedTask;
use App\Http\Resources\taskResource;

class CommentController extends Controller
{
    public function store(Request $req, $id)
    {
        try{
            $this->validate($req , [
                'body'=>'required',
            ]);
            $task=Task::findOrFail($id);
            $task->comments()->create([
                'body' => $req->body,
                'user_id' => auth()->id(),
            ]);
            event(new updatedTask(new taskResource($task)));
            return response()->json($task->comments(), 200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }
}
