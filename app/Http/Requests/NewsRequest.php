<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
        return __('attributes.news');
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
            'title' => 'required|string',
            'content' => 'required|string',
        ];
    }
}
