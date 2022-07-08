<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Http\FormRequest;

class SystemInformationRequest extends FormRequest
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
        return __('attributes.system_information');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pm_last' => 'required|array',
            'pm_last.price' => 'required|numeric',
            'pm_last.minute' => 'required|numeric',
            'companion_fee' => 'required|array',
            'companion_fee.price' => 'required|numeric',
            'nomination_fee' => 'required|array',
            'nomination_fee.price' => 'required|numeric',
            'extension_fee'=> 'required|array',
            'extension_fee.first.price'=> 'required|numeric',
            'extension_fee.first.minute'=> 'required|numeric',
            'extension_fee.second.price'=> 'required|numeric',
            'extension_fee.second.minute'=> 'required|numeric',
            'vip_fee'=> 'required|array',
            'vip_fee.price'=> 'required|numeric',
            'vip_fee.set'=> 'required|numeric',
            'shochu_fee'=> 'required|array',
            'shochu_fee.price'=> 'required|numeric',
            'shochu_fee.set'=> 'required|numeric',
            'shochu_fee.people'=> 'required|numeric',
            'brandy_fee'=> 'required|array',
            'brandy_fee.price'=> 'required|numeric',
            'brandy_fee.set'=> 'required|numeric',
            'brandy_fee.people'=> 'required|numeric',
            'whisky_fee'=> 'required|array',
            'whisky_fee.price'=> 'required|numeric',
            'whisky_fee.set'=> 'required|numeric',
            'whisky_fee.people'=> 'required|numeric',
        ];
    }
}
