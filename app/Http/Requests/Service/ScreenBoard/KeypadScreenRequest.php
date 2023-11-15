<?php

namespace App\Http\Requests\Service\ScreenBoard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class KeypadScreenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        switch($this->method())
        {
            case 'POST' ||  'PATCH' || 'PUT':
            {
                return [
                    'keypad_id' => 'nullable|exists:meeting_hall_program_session_keypads,id',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'keypad_id' => __('common.keypad'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
