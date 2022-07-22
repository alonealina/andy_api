<?php

namespace App\Http\Requests;

use App\Enums\TurnoverDetailType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class TurnoverDetailRequest extends FormRequest
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
        return __('attributes.turnover_details');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:' . implode(',', TurnoverDetailType::getValues()),
        ];
    }
}
