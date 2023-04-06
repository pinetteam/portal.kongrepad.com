<?php

namespace App\Http\Requests\Portal\Program\Moderator;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProgramModeratorRequest extends FormRequest
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
                    'program_id' => 'required|exists:programs,id',
                    'moderator_id' => 'required|exists:participants,id',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'program_id' => __('common.program'),
            'moderator_id' => __('common.moderator'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
