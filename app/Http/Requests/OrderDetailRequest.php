<?php

namespace App\Http\Requests;

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
            'foods' => 'required|array',
            'foods.*.id' => 'required|exists:food,id',
            'foods.*.price' => 'required|exists:food,price',
            'foods.*.quantity' => 'required|numeric',
            'drinks' => 'required|array',
            'drinks.*.id' => 'required|exists:drinks,id',
            'drinks.*.price' => 'required|exists:drinks,price',
            'drinks.*.quantity' => 'required|numeric'
        ];
    }
}
