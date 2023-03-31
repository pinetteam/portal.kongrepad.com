<?php

namespace App\Http\Requests\Portal\Meeting;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
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
                    'code' => 'required|max:255',
                    'title' => 'required|max:255',
                    'start_at' => 'nullable|date|before_or_equal:finish_at',
                    'finish_at' => 'nullable|date|after_or_equal:start_at',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'code' => __('common.code'),
            'title' => __('common.title'),
            'start_at' => __('common.start-at'),
            'finish_at' => __('common.finish-at'),
            'status' => __('common.status'),
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
