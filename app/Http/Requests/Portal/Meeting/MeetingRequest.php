<?php

namespace App\Http\Requests\Portal\Meeting;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'title' => 'required|max:255',
                    'start_at' => 'nullable|date|before_or_equal:finish_at',
                    'finish_at' => 'nullable|date|after_or_equal:start_at',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {
                return [
                    'title' => 'required|max:255',
                    'start_at' => 'nullable|date|before_or_equal:finish_at',
                    'finish_at' => 'nullable|date|after_or_equal:start_at',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }

    public function filters()
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
