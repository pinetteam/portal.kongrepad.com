<?php

namespace App\Http\Requests\Portal\Meeting\Hall\Program\Debate\Team\Vote;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
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
                    'team_id' => 'required|exists:meeting_hall_program_debate_teams,id',
                    'participant_id' => 'required|exists:meeting_participants,id',
                ];
            }
            default:break;
        }
    }
    public function attributes(): array
    {
        return [
            'team_id' => __('common.team'),
            'participant_id' => __('common.participant'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
