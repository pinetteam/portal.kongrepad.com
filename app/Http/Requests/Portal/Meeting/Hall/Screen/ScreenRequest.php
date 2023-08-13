<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Screen;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ScreenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'hall_id' => 'required|exists:meeting_halls,id',
            'code' => 'nullable|max:255',
            'title' => 'required|max:255',
            'description' => 'nullable|max:65535',
            'type' => 'required|in:document,participant,chair',
            'status' => 'required|boolean',
        ];
    }
    public function attributes(): array
    {
        return [
            'hall_id' => __('common.hall'),
            'code' => __('common.code'),
            'title' => __('common.title'),
            'description' => __('common.description'),
            'type' => __('common.type'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'screen')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
