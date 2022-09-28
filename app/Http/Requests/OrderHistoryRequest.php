<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderHistoryRequest extends FormRequest
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
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|after_or_equal:start_date',
            'table_number' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'end_date.after_or_equal' => '終了日は開始日または開始日より後の日付を指定してください。'
        ];
    }
}
