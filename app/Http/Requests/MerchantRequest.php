<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
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
        // $id = $this->route('merchant');
        // $unique_email = (!empty($id)) ? 'unique:merchants,email,' . $id : 'unique:merchants,email';
        // $unique_phone = (!empty($id)) ? 'unique:merchants,phone,' . $id : 'unique:merchants,phone';

        $rules = [
            'name' => 'required',
            'email' => 'required|email:rfc',
            'phone' => 'numeric|',
            'address' => 'required',
            // 'description' => 'required',
        ];
        return $rules;
    }
}
