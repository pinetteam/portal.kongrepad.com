<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Program\Session;

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
                    'program_id' => 'required|exists:meeting_hall_programs,id',
                    'speaker_id' => 'required|exists:meeting_participants,id',
                    'document_id' => 'nullable|exists:meeting_documents,id',
                    'sort_order' => 'nullable|integer',
                    'code' => 'nullable|max:255',
                    'title' => 'required|max:255',
                    'description' => 'nullable|max:65535',
                    'start_at' => 'required|date_format:Y-m-d H:i|before_or_equal:finish_at|required_with:finish_at',
                    'finish_at' => 'required|date_format:Y-m-d H:i|after_or_equal:start_at|required_with:start_at',
                    'questions' => 'boolean|required',
                    'questions_auto_start' => 'boolean|required_if:questions,1',
                    'questions_limit' => 'required_if:questions,1|integer',
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
            'speaker_id' => __('common.speaker'),
            'document_id' => __('common.document'),
            'sort_order' => __('common.sort'),
            'code' => __('common.code'),
            'title' => __('common.title'),
            'description' => __('common.description'),
            'start_at' => __('common.start-at'),
            'finish_at' => __('common.finish-at'),
            'questions' => __('common.questions'),
            'questions_limit' => __('common.question-limit'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'session')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
