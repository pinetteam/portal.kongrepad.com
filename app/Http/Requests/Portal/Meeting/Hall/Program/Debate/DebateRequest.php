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
                    'program_id' => 'required|exists:meeting_hall_programs,id',
                    'sort_order' => 'nullable|integer',
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
            'program_id' => __('common.program'),
            'sort_order' => __('common.moderator'),
            'code' => __('common.code'),
            'title' => __('common.title'),
            'description' => __('common.description'),
            'voting_started_at' => __('common.voting-started-at'),
            'voting_finished_at' => __('common.voting-finished-at'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'debate')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
