<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LevelRequest extends FormRequest
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
            'level' => 'required',
            'total_member' => 'required',
            'total_member_pack' => 'required',
            'total_member_level' => 'required',
            'shopping_month' => 'required',
            'total_turnover' => 'required',
            'commission_level_percent' => 'required',
            'commission_level_nominal' => 'required',
            'total_commission' => 'required',
            'profit_assumption' => 'required',
            'income_administration' => 'required',
            'accumulation_administrative_income' => 'required',
        ];
        return $rules;
    }
}
