<?php

namespace App\Http\Requests\Service\ScreenBoard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DocumentScreenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        switch($this->method())
        {
            case 'POST' ||  'PATCH' || 'PUT':
            {
                return [
                    'document_id' => 'nullable|exists:meeting_documents,id',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'document_id' => __('common.document'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
