<?php

namespace App\Http\Requests\Portal\Document;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

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
            case 'POST':
            {
                return [
                    'participant_id' => 'required|exists:participants,id',
                    'file' => ['required', File::types(['pdf', 'pptx', 'xls', 'xlsx'])->max(10240)],
                    'title' => 'nullable|max:255',
                    'type' => 'required|in:presentation,publication,other',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {
                return [
                    'participant_id' => 'required|exists:participants,id',
                    'file' => ['nullable', File::types(['pdf', 'pptx', 'xls', 'xlsx'])->max(10240)],
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
