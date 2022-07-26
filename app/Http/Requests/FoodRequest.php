<?php

namespace App\Http\Requests;

use App\Enums\InventoryStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FoodRequest extends FormRequest
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
        return __('attributes.foods');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'food_category_id' => 'required|exists:food_categories,id',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'string|nullable',
            'status' => 'in:' . implode(',', InventoryStatus::getValues()),
            'images.*' => 'mimes:jpg,jpeg,png|max:5000'
        ];
    }
}
