<?php

namespace App\Http\Requests\Portal\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PhoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone',
            'phone' => 'nullable|max:31|required_with:phone_country_id',
        ];
    }
    public function attributes(): array
    {
        return [
            'phone_country_id' => __('common.phone-country'),
            'phone' => __('common.phone'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'user')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
