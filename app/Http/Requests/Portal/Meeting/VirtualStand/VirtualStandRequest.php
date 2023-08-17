<?php

namespace App\Http\Requests\Portal\Meeting\VirtualStand;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class VirtualStandRequest extends FormRequest
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
                    'file' => ['required', File::types(['png', 'jpg', 'jpeg'])],
                    'title' => 'required|max:255',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {
                return [
                    'meeting_id' => 'required|exists:meetings,id',
                    'file' => ['nullable', File::types(['png', 'jpg', 'jpeg'])],
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
            'meeting_id' => __('common.meeting'),
            'file' => __('common.file'),
            'title' => __('common.title'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'document')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
