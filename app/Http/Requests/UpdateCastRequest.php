<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCastRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'height' => 'numeric|min:100|max:500|nullable',
            'blood_type' => 'numeric|min:0|max:8',
            'hobbit' => 'string|nullable',
            'type_person' => 'string|nullable',
            'dream' => 'string|nullable',
            'fetish' => 'string|nullable',
            'slogan' => 'string|nullable',
            'instagram_url' => 'string|nullable',
            'special_skill' => 'string|nullable',
            'images' => 'array',
            'images.*.file_name' => 'string|nullable',
            'images.*.file' => 'mimes:jpg,jpeg,png|max:5000|nullable'
        ];
    }

    /**
     * @return array|Application|Translator|string|null
     */
    public function attributes()
    {
        return __('attributes.casts');
    }
}
