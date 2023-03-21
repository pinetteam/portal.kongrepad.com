<?php

namespace App\Http\Requests\Portal\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'user_role_id' => 'required|exists:user_roles,id',
                    'username' => 'required|unique|max:255',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|unique|max:255',
                    'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone,phone-country-code',
                    'phone' => 'nullable|max:31|required_with:phone_country_id,phone',
                    'password' => 'required|max:255',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {
                return [
                    'user_role_id' => 'required|exists:user_roles,id',
                    'username' => ['required', Rule::unique('users','username')->ignore($this->username,'username'), 'max:255'],
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => ['required', Rule::unique('users','email')->ignore($this->email,'email'), 'max:255'],
                    'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone,phone-country-code',
                    'phone' => 'nullable|max:31|required_with:phone_country_id,phone',
                    'password' => 'nullable|max:255',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }

    public function filters()
    {
        return [
            'email' => 'trim|lowercase',
            'username' => 'trim|lowercase|escape'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
