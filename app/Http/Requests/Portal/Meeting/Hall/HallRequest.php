<?php

namespace App\Http\Requests\Portal\Meeting\Hall;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class HallRequest extends FormRequest
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
                    'meeting_id' => 'required|exists:meetings,id',
                    'title' => 'required|max:511',
                    'show_on_session' => 'required|boolean',
                    'show_on_ask_question' => 'required|boolean',
                    'show_on_view_program' => 'required|boolean',
                    'show_on_send_mail' => 'required|boolean',
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
            'show_on_session' => __('common.show-on-session'),
            'show_on_ask_question' => __('common.show-on-ask-question'),
            'show_on_view_program' => __('common.show-on-view-program'),
            'show_on_send_mail' => __('common.show-on-send-mail'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'hall')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
