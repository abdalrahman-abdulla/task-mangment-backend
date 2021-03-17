<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class tasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arrayData= [
            'id' => $this->id,
            'title' => $this->title,
            'department' => [
                'name'=> $this->department->name,
                'id'=> $this->department->id,
            ],
            'start_date' => Carbon::createFromFormat('Y-m-d', $this->start_date)->toDateString(),
            'deadline' => Carbon::createFromFormat('Y-m-d', $this->start_date)->addDays($this->deadline)->toDateString(),
            'description' =>$this->description,
            'progress' =>$this->progress,
            'comments' => count($this->comments)
        ];
        if($this->progress!=0){
            $arrayData['user_id']=$this->user()->id;
        }
        return $arrayData;

    }
}
