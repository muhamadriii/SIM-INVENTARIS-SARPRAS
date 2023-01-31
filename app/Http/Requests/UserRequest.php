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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$this->user,
            'email' => 'required|email|unique:users,email,'.$this->user,
        ];
        //udah gakepake karena sekarang update pake method post juga
        // if($this->method() == 'POST') $rules['password'] = 'required';

        if(strlen($this->path()) < 13) $rules['password'] = 'required';
        return $rules;
    }
}
