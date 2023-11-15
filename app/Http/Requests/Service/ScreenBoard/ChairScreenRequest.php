<?php

namespace App\Http\Requests\Service\ScreenBoard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChairScreenRequest extends FormRequest
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
                    'chair_id' => 'nullable|exists:meeting_participants,id',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'chair_id' => __('common.chair'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
