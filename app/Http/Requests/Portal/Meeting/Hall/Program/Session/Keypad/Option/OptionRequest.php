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
                    'keypad_id' => 'required|exists:meeting_hall_program_session_keypads,id',
                    'sort_order' => 'nullable|integer',
                    'option' => 'required|max:255',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'keypad_id' => __('common.keypad'),
            'sort_order' => __('common.sort-order'),
            'option' => __('common.title'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'option')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
