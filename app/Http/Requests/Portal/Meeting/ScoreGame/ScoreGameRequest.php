<?php

namespace App\Http\Requests\Portal\Meeting\ScoreGame;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ScoreGameRequest extends FormRequest
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
                    'start_at' => 'required|date_format:Y-m-d H:i|before_or_equal:finish_at|required_with:finish_at',
                    'finish_at' => 'required|date_format:Y-m-d H:i|after_or_equal:start_at|required_with:start_at',
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
            'start_at' => __('common.start-at'),
            'finish_at' => __('common.finish-at'),
            'title' => __('common.title'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
