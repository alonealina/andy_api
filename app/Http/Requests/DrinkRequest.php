<?php

namespace App\Http\Requests;

use App\Enums\InventoryStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class DrinkRequest extends FormRequest
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
     * @return array|Application|Translator|string|null
     */
    public function attributes()
    {
        return __('attributes.drinks');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'drink_category_id' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'status' => 'in:' . implode(',', InventoryStatus::getValues()),
            'images.*' => 'mimes:jpg,jpeg,png|max:5000'
        ];
    }
}
