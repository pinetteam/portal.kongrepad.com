<?php

namespace App\Http\Requests\License;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

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
                    'email' => 'required|email|max:255',
                    'username' => 'required|max:255',
                    'password' => 'required|min:6',
                    'repeat_password' => 'required_with:password|same:password|min:6',
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
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'license')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
