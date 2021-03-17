<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required',
            'description'=>'required',
            'department_id'=>'required|exists:departments,id',
            'start_date'=>'required',
            'deadline'=>'required|numeric',
            'budget'=>'required|numeric|digits_between:1,9',
            'resources'=> 'sometimes|required',
            'requirements'=> 'required'
        ];
    }
}
