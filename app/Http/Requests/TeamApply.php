<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamApply extends FormRequest
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
            'team' => 'required|min:3|max:25|unique_team_name_in_current_contest',
            'member1_first_name' => 'required',
            'member1_last_name' => 'required',
            'member1_dob' => 'bail|required|date_format:Y-m-d|eligible_age',
            'member2_first_name' => 'required',
            'member2_last_name' => 'required',
            'member2_dob' => 'bail|required|date_format:Y-m-d|eligible_age',
            'teacher_first_name' => 'required',
            'teacher_last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:6,15',
            'sumo' => 'required_without_all:obstacles',
            'obstacles' => 'required_without_all:sumo',
        ];
    }
}
