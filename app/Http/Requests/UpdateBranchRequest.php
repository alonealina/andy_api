<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
        return __('attributes.branches');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rule = [
            'admin_username' => 'required|unique:accounts,username,' . $this->branch->admin_id,
            'admin_password' => 'required|min:8',
            'name' => 'required|string',
            'tablet_count' => 'required|numeric',
        ];
        if (isset($this->images[0]) && !is_string($this->images[0])) {
            $rule['images.*'] = 'mimes:jpg,jpeg,png|max:5000';
        } else {
            $rule['images.*'] = 'string|nullable';
        }
        return $rule;
    }
}
