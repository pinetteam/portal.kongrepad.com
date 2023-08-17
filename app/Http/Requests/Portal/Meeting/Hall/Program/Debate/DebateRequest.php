<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Program\Debate;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DebateRequest extends FormRequest
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
                    'program_id' => 'required|exists:meeting_hall_programs,id',
                    'code' => 'nullable|max:255',
                    'title' => 'required|max:255',
                    'description' => 'nullable|max:65535',
                    'status' => 'boolean|required',
                    ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'sort_order' => __('common.moderator'),
            'program_id' => __('common.program'),
            'code' => __('common.code'),
            'title' => __('common.title'),
            'description' => __('common.description'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'debate')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
