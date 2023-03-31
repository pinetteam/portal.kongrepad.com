<?php

namespace App\Http\Requests\Portal\Session;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SessionRequest extends FormRequest
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
                    'session_id' => 'nullable|exists:sessions,id',
                    'meeting_hall_id' => 'required|exists:meeting_halls,id',
                    'sort_id' => 'nullable|integer',
                    'code' => 'nullable|max:255',
                    'title' => 'required|max:255',
                    'description' => 'nullable|max:65535',
                    'date' => 'required|date',
                    'start_at' => 'nullable|date_format:H:i|date|before_or_equal:finish_at|required_with:finish_at',
                    'finish_at' => 'nullable|date_format:H:i|date|after_or_equal:start_at|required_with:start_at',
                    'type' => 'required|in:main-session,event,course,presentation,break,other',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'start_at' => __('common.start-at'),
            'finish_at' => __('common.finish-at'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
