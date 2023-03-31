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
                    'user_role_id' => 'required|exists:user_roles,id',
                    'username' => 'required|unique:users,username|max:255',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|unique:users,email|max:255',
                    'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone',
                    'phone' => 'nullable|max:31|required_with:phone_country_id',
                    'password' => 'required|max:255',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {
                return [
                    'user_role_id' => 'required|exists:user_roles,id',
                    'username' => ['required', Rule::unique('users','username')->ignore($this->username, 'username'), 'max:255'],
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => ['required', 'email', Rule::unique('users','email')->ignore($this->email, 'email'), 'max:255'],
                    'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone',
                    'phone' => 'nullable|max:31|required_with:phone_country_id',
                    'password' => 'nullable|max:255',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'user_role_id' => __('common.user-role'),
            'username' => __('common.username'),
            'first_name' => __('common.first-name'),
            'last_name' => __('common.last-name'),
            'email' => __('common.email'),
            'phone_country_id' => __('common.phone-country-code'),
            'phone' => __('common.phone'),
            'password' => __('common.password'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
