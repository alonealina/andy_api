<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * Define attributes
     *
     * @return array|Application|Translator|string|null
     */
    public function attributes()
    {
        return __('attributes.users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request('email') !== null && is_numeric(request('email'))) {
            return [
                'email' => 'required|numeric',
                'password' => 'required|min:8'
            ];
        }
        return [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];
    }
}
