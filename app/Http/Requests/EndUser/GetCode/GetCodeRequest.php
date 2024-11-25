<?php

namespace App\Http\Requests\EndUser\GetCode;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class GetCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
                    'type' => 'required|in:email,sms',
                    'email' => 'nullable|email|max:255|required_if:type,email',
                    'phone' => 'nullable|min:10|max:10|required_if:type,sms',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'type' => __('common.type'),
            'email' => __('common.email'),
            'phone' => __('common.phone'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'get-code')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
