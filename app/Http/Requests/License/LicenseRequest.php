<?php

namespace App\Http\Requests\License;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class LicenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        switch($this->method())
        {
            case 'POST' || 'PATCH' || 'PUT':
            {
                return [
                    'title' => 'required|max:255',
                    'email' => 'required|unique:users,email|email|max:255',
                    'username' => 'required|unique:users,username|max:255',
                    'password' => 'required|min:6',
                    //'logo' => ['nullable', File::types(['png'])->max(24 * 1024),],
                    //'web-address' => 'nullable|max:255',
                    //'address' => 'nullable|max:512',
                    'repeat_password' => 'required_with:password|same:password|min:6',
                    'phone_country' => 'required|required_with:phone',
                    'phone' => 'required|max:31|required_with:phone_country_id',
                    //'timezone' => 'nullable',
                    //'time_format' => 'nullable',
                    //'date_format' => 'nullable',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'title' => __('common.title'),
            'email' => __('common.email'),
            'username' => __('common.username'),
            'password' => __('common.password'),
            'repeat_password' => __('common.repeat-password'),
            //'phone_country' => __('common.phone-country'),
            //'web_address' => __('common.web_address'),
            //'address' => __('common.address'),
            //'timezone' => __('common.timezone'),
            //'time_format' => __('common.time-format'),
            //'date_format' => __('common.date-format'),
            'phone' => __('common.phone'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'license')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
