<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\Option;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
                    'keypad_id' => 'required|exists:meeting_hall_program_session_keypads,id',
                    'option' => 'required|max:255',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'sort_order' => __('common.sort-order'),
            'keypad_id' => __('common.keypad'),
            'option' => __('common.option'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'option')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
