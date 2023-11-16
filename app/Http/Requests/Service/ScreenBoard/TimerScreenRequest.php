<?php

namespace App\Http\Requests\Service\ScreenBoard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TimerScreenRequest extends FormRequest
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
                    'time' => 'nullable|integer',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'time' => __('common.time'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
