<?php

namespace App\Http\Requests;

use App\Enums\MaintainRole;
use App\Enums\MaintainStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class MaintainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array|Application|Translator|string|null
     */
    public function attributes()
    {
        return __('attributes.maintain');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'branch_ids' => 'required|array',
            'branch_ids.*' => 'required|exists:branches,id',
            'role' => 'required|in:' . implode(',', MaintainRole::getValues()),
            'maintain_status' => 'required|in:' . implode(',', MaintainStatus::getValues()),
            'message' => 'string|nullable',
            'start_time' => 'required_if:maintain_status,==,' . MaintainStatus::MAINTAIN . '|date_format:Y-m-d H:i',
            'end_time' => 'required_if:maintain_status,==,' . MaintainStatus::MAINTAIN . '|date_format:Y-m-d H:i',
        ];
    }
}
