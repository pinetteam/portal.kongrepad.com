<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class KeypadRequest extends FormRequest
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
                    'sort_order' => 'nullable|integer',
                    'session_id' => 'required|exists:meeting_hall_program_sessions,id',
                    'code' => 'nullable|max:255',
                    'title' => 'required|max:255',
                    'keypad' => 'required|max:255',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'session_id' => __('common.session'),
            'sort_order' => __('common.sort-order'),
            'code' => __('common.code'),
            'title' => __('common.title'),
            'keypad' => __('common.keypad'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'keypad')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
