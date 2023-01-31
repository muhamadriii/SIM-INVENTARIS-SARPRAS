<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'no_policy' => 'required',
            'no_police' => 'required',
            'transportation_type' => 'required',
            'sales_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'premium_amount' => 'required',
            'fee_amount' => 'required',
        ];
        return $rules;
    }
}
