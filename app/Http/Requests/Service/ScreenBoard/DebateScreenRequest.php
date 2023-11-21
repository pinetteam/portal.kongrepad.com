<?php

namespace App\Http\Requests\Service\ScreenBoard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DebateScreenRequest extends FormRequest
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
                    'debate_id' => 'nullable|exists:meeting_hall_program_debates,id',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'debate_id' => __('common.debate'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
