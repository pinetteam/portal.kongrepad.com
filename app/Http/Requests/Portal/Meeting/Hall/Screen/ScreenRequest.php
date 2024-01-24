<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Screen;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

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
            'title' => 'required|max:255',
            'font' => 'required|in:Roboto,Hedvig Letters Serif,Open Sans,Montserrat,Nunito',
            'font_size' => 'required|integer',
            'font_color' => ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'background' => ['nullable', File::types(['png','jpg','jpeg'])->max(12 * 1024),],
            'description' => 'nullable|max:65535',
            'type' => 'required|in:chair,document,debate,keypad,questions,speaker,timer',
            'status' => 'required|boolean',
        ];
    }
    public function attributes(): array
    {
        return [
            'hall_id' => __('common.hall'),
            'title' => __('common.title'),
            'description' => __('common.description'),
            'font' => __('common.font'),
            'font_size' => __('common.font-size'),
            'font_color' => __('common.font-color'),
            'background' => __('common.background'),
            'type' => __('common.type'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'screen')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
