<?php

namespace App\Http\Requests\Portal\Document;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
                    'meeting_id' => 'required|exists:meetings,id',
                    'participant_id' => 'nullable|exists:meetings,id',
                    'file' => 'required',
                    'title' => 'nullable|max:255',
                    'type' => 'required|in:presentation,publication,other',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {
                return [
                    'meeting_id' => 'required|exists:meetings,id',
                    'participant_id' => 'nullable|exists:meetings,id',
                    'file' => 'nullable',
                    'title' => 'nullable|max:255',
                    'type' => 'required|in:presentation,publication,other',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'meeting_id' => __('common.meeting'),
            'participant_id' => __('common.participant'),
        ];
    }
    public function filters(): array
    {
        return [
            'title' => 'trim',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
