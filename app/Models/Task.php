<?php

namespace App\Models;
use App\Models\Comment;
use App\Models\Department;
use App\Models\Request;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title','description','department_id','start_date','deadline','budget','requirements','resources','progress','link',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class,'requests')->where('status',true)->first();
    }
}
