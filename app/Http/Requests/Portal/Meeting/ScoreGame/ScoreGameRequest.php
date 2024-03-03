<?php

namespace App\Http\Requests\Portal\Meeting\ScoreGame;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

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
                    'title' => 'required|max:255',
                    'logo' => ['nullable', File::types(['png'])->max(12 * 1024),],
                    'start_at' => 'required|date_format:Y-m-d H:i|before_or_equal:finish_at|required_with:finish_at',
                    'finish_at' => 'required|date_format:Y-m-d H:i|after_or_equal:start_at|required_with:start_at',
                    'theme' => 'required|in:score_game,donation',
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
            'logo' => __('common.logo'),
            'start_at' => __('common.start-at'),
            'finish_at' => __('common.finish-at'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'score-game')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
