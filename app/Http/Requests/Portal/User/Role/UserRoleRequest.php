<?php

namespace App\Http\Requests\Portal\User\Role;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRoleRequest extends FormRequest
{
    /**
     * Determine if the Branch is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'title' => 'required|max:255',
                    'access_scopes' => 'array',
                    'status' => 'required|boolean',
                ];
            }
            case 'PATCH' || 'PUT':
            {

                return [
                    'title' => 'required|max:255',
                    'access_scopes' => 'array',
                    'status' => 'required|boolean',
                ];
            }
            default:break;
        }
    }

    public function filters()
    {

    }

    public function failedValidation(Validator $validator)
    {
        return back()->with('method', $this->method())->with('route', url()->current())->withErrors($this->validator)->withInput();
    }
}
