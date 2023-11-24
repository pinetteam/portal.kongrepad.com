<?php

namespace App\Http\Requests\Portal\Meeting\Announcement;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
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
                    'title' => 'required|max:511',
                    'publish_at' => 'required|date_format:Y-m-d H:i',
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
            'title' => __('common.title'),
            'publish_at' => __('common.publish-at'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'announcement')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
