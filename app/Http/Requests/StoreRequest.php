<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        return __('attributes.stores');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'store_category_id' => 'required|exists:store_categories,id',
            'post_code_1' => 'numeric',
            'post_code_2' => 'numeric',
            'address' => 'max:100',
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i',
            'payment_method' => 'array',
            'payment_method.*' => 'in:' . implode(',', PaymentMethod::getValues()),
            'counter_count' => 'integer',
            'table_count' => 'integer',
            'room_count' => 'integer',
            'stand_count' => 'integer',
            'hotline' => 'max:100',
            'homepage_url' => 'url|max:255',
            'images.*' => 'mimes:jpg,jpeg,png|max:5000'
        ];
    }
}
