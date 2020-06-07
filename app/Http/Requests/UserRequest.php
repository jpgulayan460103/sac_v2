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
        if(request()->has('id')){
            $id = request('id');
        }
        return [
            'username' => 'required|unique:users,username,'.$id.',id|max:12',
            'name' => 'required|min:3|max:80',
            'password' => 'required|confirmed|min:6|max:16',
        ];
    }
}
