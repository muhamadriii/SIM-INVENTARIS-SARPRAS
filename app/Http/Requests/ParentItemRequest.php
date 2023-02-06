<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParentItemRequest extends FormRequest
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
            // 'unit_id' => 'required',
            // 'category_id' => 'required',
            // 'name' => 'required',
            // 'image' => 'required',
            // 'suplier' => 'required',
            // 'price' => 'required',
        ];

        return $rules;
    }
}
