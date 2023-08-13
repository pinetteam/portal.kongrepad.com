<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Program\Debate\Team;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class TeamRequest extends FormRequest
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
                    'debate_id' => 'required|exists:meeting_hall_program_debates,id',
                    'code' => 'nullable|max:255',
                    'logo' => ['nullable', File::types(['png'])->max(12 * 1024),],
                    'title' => 'required|max:255',
                    'description' => 'nullable|max:65535',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'debate_id' => __('common.debate'),
            'code' => __('common.code'),
            'title' => __('common.title'),
            'description' => __('common.description'),
            ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'team')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
