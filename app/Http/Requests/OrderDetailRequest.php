<?php

namespace App\Http\Requests;

use App\Enums\OrderDetailStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class OrderDetailRequest extends FormRequest
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
        return __('attributes.order_details');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'foods' => 'array',
            'foods.*.id' => 'exists:foods,id',
            'foods.*.price' => 'exists:foods,price',
            'foods.*.quantity' => 'numeric',
            'drinks' => 'array',
            'drinks.*.id' => 'exists:drinks,id',
            'drinks.*.price' => 'exists:drinks,price',
            'drinks.*.quantity' => 'numeric',
            'images.*' => 'mimes:jpg,jpeg,png|max:5000'
        ];
    }
}
