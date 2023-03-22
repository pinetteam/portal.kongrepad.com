<?php

namespace App\Http\Requests\Portal\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'username' => 'required|unique|max:255',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|unique|max:255',
                    'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone,phone-country-code',
                    'phone' => 'nullable|max:31|required_with:phone_country_id,phone',
                    'password' => 'required|max:255',
                    'user_role_id' => 'required|exists:user_roles,id',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {
                return [
                    'username' => ['required', Rule::unique('users','username')->ignore($this->username,'username'), 'max:255'],
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => ['required', 'email', Rule::unique('users','email')->ignore($this->email,'email'), 'max:255'],
                    'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone,phone-country-code',
                    'phone' => 'nullable|max:31|required_with:phone_country_id,phone',
                    'password' => 'nullable|max:255',
                    'user_role_id' => 'required|exists:user_roles,id',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'first_name' => __('common.first-name'),
            'last_name' => __('common.last-name'),
            'phone_country_id' => __('common.phone-country-code'),
            'user_role_id' => __('common.user-role'),
        ];
    }
    public function filters(): array
    {
        return [
            'username' => 'trim|lowercase|escape',
            'email' => 'trim|lowercase',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
