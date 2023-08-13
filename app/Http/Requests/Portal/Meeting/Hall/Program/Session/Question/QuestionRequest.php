<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Program\Session\Question;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
                    'owner_id' => 'required|exists:meeting_participants,id',
                    'sort_order' => 'nullable|integer',
                    'title' => 'required|max:255',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'session_id' => __('common.session'),
            'owner_id' => __('common.owner'),
            'sort_order' => __('common.sort-order'),
            'title' => __('common.title'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'question')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
