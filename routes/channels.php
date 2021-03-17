<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('tasks.{id}', function ($user,$id) {
    if($user->user_type==0){
        return true;
    }
    return $user->department_id == $id;
});

Broadcast::channel('task.{id}.{task_id}', function ($user,$id) {
    if($user->user_type==0){
        return true;
    }
    return $user->department_id == $id;
});
