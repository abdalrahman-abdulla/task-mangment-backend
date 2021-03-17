<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\userResource;
use App\Http\Resources\commentResource;
use App\Http\Resources\requestResource;

class taskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arrayData = [
            'id' => $this->id,
            'title' => $this->title,
            'department' => [
                'name'=> $this->department->name,
                'id'=> $this->department->id,
            ],
            'start_date' => Carbon::createFromFormat('Y-m-d', $this->start_date)->toDateString(),
            'deadline' => $this->deadline,
            'budget' => $this->budget,
            'created_at' => $this->created_at->toDateString(),
            'requirements' => explode(",",$this->requirements),
            'description' =>$this->description,
            'progress' =>$this->progress,
            'updated_at' => $this->updated_at->toDateString(),
            'comments' => commentResource::collection($this->comments)
        ];
        if($this->resources){
            $arrayData['resources']=explode(",",$this->resources);
        }
        if(!$this->progress==0){
            $arrayData['user']=new userResource($this->user());
            $arrayData['work_link']=$this->file;
        }
        if($this->progress==0){
            if(!sizeof($this->requests->where('user_id',auth()->user()->id))){
                $arrayData['canreq']=true;
            } else {
                $arrayData['canreq']=false;
            }
        }
        if(!auth()->user()->user_type){
            $arrayData['requests'] = requestResource::collection($this->requests()->get());
        }
        return $arrayData;
    }
}
