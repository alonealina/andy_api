<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
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
            'is_service' => 'required|boolean',
            'is_overtime' => 'required|boolean',
            'year' => 'required|numeric',
            'month' => 'required|numeric',
            'schedules' => 'required|array',
            'schedules.*.day' => 'numeric',
            'schedules.*.working_time' => 'array',
            'schedules.*.working_time.*.start' => 'date_format:H:i',
            'schedules.*.working_time.*.end' => 'date_format:H:i',
        ];
    }
}
