<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Program\Chair;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChairRequest extends FormRequest
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
                    'program_id' => 'required|exists:meeting_hall_programs,id',
                    'chair_id' => 'required|exists:meeting_participants,id',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'program_id' => __('common.program'),
            'chair_id' => __('common.moderator'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'chair')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
