<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'schedule_details' => 'required|array',
            'schedule_details.*.day' => 'numeric',
            'schedule_details.*.working_time' => 'array',
            'schedule_details.*.working_time.*.start' => 'date_format:H:i',
            'schedule_details.*.working_time.*.end' => 'date_format:H:i',
        ];
    }
}
