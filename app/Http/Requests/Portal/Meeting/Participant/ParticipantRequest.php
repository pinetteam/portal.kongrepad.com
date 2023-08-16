<?php

namespace App\Http\Requests\Portal\Meeting\Participant;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

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
                    'title' => 'nullable|max:255',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'identification_number' => 'nullable|max:255',
                    'organisation' => 'nullable|max:255',
                    'email' => 'required|email|max:255',
                    'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone',
                    'phone' => 'nullable|max:31|required_with:phone_country_id',
                    'password' => 'required|max:255',
                    'type' => 'required|in:agent,attendee,team',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {
                return [
                    'meeting_id' => 'required|exists:meetings,id',
                    'title' => 'nullable|max:255',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'identification_number' => 'nullable|max:255',
                    'organisation' => 'nullable|max:255',
                    'email' => 'required|email|max:255',
                    'phone_country_id' => 'nullable|exists:system_countries,id|required_with:phone',
                    'phone' => 'nullable|max:31|required_with:phone_country_id',
                    'password' => 'required|max:255',
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
            'username' => __('common.username'),
            'title' => __('common.title'),
            'first_name' => __('common.first-name'),
            'last_name' => __('common.last-name'),
            'identification_number' => __('common.identification-number'),
            'organisation' => __('common.organisation'),
            'email' => __('common.email'),
            'phone_country_id' => __('common.phone-country'),
            'phone' => __('common.phone'),
            'password' => __('common.password'),
            'type' => __('common.type'),
            'status' => __('common.status'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('name', 'participant')->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
