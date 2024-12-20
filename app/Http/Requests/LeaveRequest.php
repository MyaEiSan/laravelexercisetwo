<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        // dd($this->method());
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        // if update and create have differences like input name difference or have unique columns , you can write as below 

        if($this->method() == "POST"){
            return [
                'post_id' => 'required|array',
                'post_id.*' => 'exists:posts,id',
                'startdate' => 'required|date',
                'enddate' => 'required|date|after_or_equal:startdate',
                'tag' => 'required',
                'title' => 'required|max:50',
                'content' => 'required',
                'image' => 'nullable|array',
                'image.*' => 'nullable|image|mimes:jpg,jpeg,png|max:1024'

            ];
        }else{
            return [
                'post_id' => 'required|array',
                'post_id.*' => 'exists:posts,id',
                'startdate' => 'required|date',
                'enddate' => 'required|date|after_or_equal:startdate',
                'tag' => 'required',
                'title' => 'required|max:50',
                'content' => 'required',
                'image' => 'nullable|array',
                'image.*' => 'nullable|image|mimes:jpg,jpeg,png|max:1024'

            ];
        }
        
    }

    public function attributes(){
        return [
            'post_id' => 'class',
            'startdate' => 'start date',
            'enddate' => 'end date',
            'tag' => 'authorize person'
        ];
    }

    public function messages()
    {
        return [
            'post_id.required' => "class name can't be empty",
            'startdate.required' => "start date can't be empty",
            'enddate.required' => 'end date can\'t be empty',
            'tag.required' => 'authorize person must be choose'
        ];
    }
}

// php artisan make:request LeaveRequest 
