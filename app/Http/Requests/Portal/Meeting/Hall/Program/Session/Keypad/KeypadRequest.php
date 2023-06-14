<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class KeypadRequest extends FormRequest
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
                    'session_id' => 'required|exists:meeting_hall_program_sessions,id',
                    'sort_order' => 'nullable|integer',
                    'code' => 'nullable|max:255',
                    'title' => 'required|max:255',
                    'status' => 'boolean|required',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'session_id' => __('common.session'),
            'sort_order' => __('common.moderator'),
            'code' => __('common.code'),
            'title' => __('common.title'),
            'on-vote' => __('common.on-vote'),
            'voting_started_at' => __('common.voting-started-at'),
            'voting_finished_at' => __('common.voting-finished-at'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
