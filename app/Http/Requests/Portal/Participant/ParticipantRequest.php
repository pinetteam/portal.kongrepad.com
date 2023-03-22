<?php

namespace App\Http\Requests\Portal\Participant;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParticipantRequest extends FormRequest
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
                    'meeting_id' => 'required|exists:meetings,id',
                    'username' => 'required|unique:participants,username|max:255',
                    'title' => 'nullable|max:255',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255',
                    'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone',
                    'phone' => 'nullable|max:31|required_with:phone_country_id',
                    'password' => 'required|max:255',
                    'type' => 'required|in:agent,attendee,chair,speaker,team',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {
                return [
                    'meeting_id' => 'required|exists:meetings,id',
                    'username' => ['required', Rule::unique('participants','username')->ignore($this->username, 'username'), 'max:255'],
                    'title' => 'nullable|max:255',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255',
                    'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone',
                    'phone' => 'nullable|max:31|required_with:phone_country_id',
                    'password' => 'required|max:255',
                    'type' => 'required|in:agent,attendee,chair,speaker,team',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'first_name' => __('common.first-name'),
            'last_name' => __('common.last-name'),
            'phone_country_id' => __('common.phone-country-code'),
        ];
    }
    public function filters(): array
    {
        return [
            'username' => 'trim|lowercase|escape',
            'email' => 'trim|lowercase',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
