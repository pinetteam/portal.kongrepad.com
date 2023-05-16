<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Program;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ProgramRequest extends FormRequest
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
                    'meeting_hall_id' => 'required|exists:meeting_halls,id',
                    'sort_id' => 'nullable|integer',
                    'code' => 'nullable|max:255',
                    'title' => 'required|max:255',
                    'description' => 'nullable|max:65535',
                    'logo' => ['nullable', File::types(['png'])->max(12 * 1024),],
                    'start_at' => 'nullable|date_format:d/m/Y H:i|before_or_equal:finish_at|required_with:finish_at',
                    'finish_at' => 'nullable|date_format:d/m/Y H:i|after_or_equal:start_at|required_with:start_at',
                    'type' => 'required|in:session,debate,other',
                    'status' => 'required|boolean',
                ];
            } case 'PATCH' || 'PUT':
            {
                return [
                    'meeting_hall_id' => 'required|exists:meeting_halls,id',
                    'sort_id' => 'nullable|integer',
                    'code' => 'nullable|max:255',
                    'title' => 'required|max:255',
                    'description' => 'nullable|max:65535',
                    'logo' => ['nullable', File::types(['png'])->max(12 * 1024),],
                    'start_at' => 'nullable|date_format:d/m/Y H:i|before_or_equal:finish_at|required_with:finish_at',
                    'finish_at' => 'nullable|date_format:d/m/Y H:i|after_or_equal:start_at|required_with:start_at',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'meeting_hall_id' => __('common.meeting-hall'),
            'sort_id' => __('common.sort'),
            'code' => __('common.code'),
            'title' => __('common.title'),
            'description' => __('common.description'),
            'logo' => __('common.logo'),
            'start_at' => __('common.start-at'),
            'finish_at' => __('common.finish-at'),
            'type' => __('common.type'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
