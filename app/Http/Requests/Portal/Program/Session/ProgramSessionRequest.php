<?php

namespace App\Http\Requests\Portal\Program\Session;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProgramSessionRequest extends FormRequest
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
                    'presenter_id' => 'required|exists:participants,id',
                    'document_id' => 'nullable|exists:documents,id',
                    'sort_id' => 'nullable|integer',
                    'code' => 'nullable|max:255',
                    'title' => 'required|max:255',
                    'description' => 'nullable|max:65535',
                    'start_at' => 'nullable|date_format:d/m/Y H:i|before_or_equal:finish_at|required_with:finish_at',
                    'finish_at' => 'nullable|date_format:d/m/Y H:i|after_or_equal:start_at|required_with:start_at',
                    'questions' => 'boolean|required',
                    'question_limit' => 'required|integer',
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
            'presenter_id' => __('common.presenter'),
            'document_id' => __('common.document'),
            'sort_id' => __('common.sort'),
            'code' => __('common.code'),
            'title' => __('common.title'),
            'description' => __('common.description'),
            'start_at' => __('common.start-at'),
            'finish_at' => __('common.finish-at'),
            'questions' => __('common.questions'),
            'question_limit' => __('common.question-limit'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
