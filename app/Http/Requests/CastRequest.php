<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class CastRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'height' => 'numeric|min:1|max:2',
            'blood_type' => 'numeric|min:1|max:8',
            'hobbit' => 'string',
            'type_person' => 'string',
            'dream' => 'string',
            'fetish' => 'string',
            'slogan' => 'string',
            'instagram_url' => 'string',
            'special_skill' => 'string',
            'images.*' => 'mimes:jpg,jpeg,png|max:5000'
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
