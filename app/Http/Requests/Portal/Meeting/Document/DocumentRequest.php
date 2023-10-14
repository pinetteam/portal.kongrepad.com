<?php

namespace App\Http\Requests\Portal\Meeting\Document;

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
                    'meeting_id' => 'required|exists:meetings,id',
                    'file' => ['required', File::types(['pdf', 'pptx', 'ppt', 'ppsx'])->max(10240)],
                    'title' => 'required|max:511',
                    'allowed_to_review' => 'required|boolean',
                    'sharing_via_email' => 'required|boolean',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {
                return [
                    'meeting_id' => 'required|exists:meetings,id',
                    'file' => ['nullable', File::types(['pdf', 'pptx', 'ppt', 'ppsx'])->max(10240)],
                    'title' => 'required|max:511',
                    'allowed_to_review' => 'required|boolean',
                    'sharing_via_email' => 'required|boolean',
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
            'file' => __('common.file'),
            'title' => __('common.title'),
            'allowed_to_review' => __('common.allowed-to-review'),
            'sharing_via_email' => __('common.sharing-via-email'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'document')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
