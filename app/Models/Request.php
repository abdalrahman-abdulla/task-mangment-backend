<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\User;

class Request extends Model
{
    protected $fillable = [
        'status','user_id'
    ];
    public function Task()
    {
        return $this->belongsTo(Task::class,'task_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
