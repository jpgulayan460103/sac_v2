<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = null;
        $change_password = false;
        if(request()->has('id')){
            $id = request('id');
        }
        if(request()->has('change_password')){
            $change_password = request('change_password');
        }
        $rules = [
            'username' => 'required|unique:users,username,'.$id.',id|max:12',
            'first_name' => 'required|min:2|max:40',
            'middle_name' => 'max:40',
            'last_name' => 'required|min:2|max:40',
            'position' => 'required',
        ];
        if($change_password){
            $rules['password'] = 'required|confirmed|min:6|max:16';
        }
        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) use ($id) {
            if(request()->has('city')){
                if(request('city') == "112402000" && !request()->has('barangay_id')){
                    $validator->errors()->add("position", "Should be LGU Barangay Staff for Davao City");
                }
            }

        });
    }
}
