<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'name'      => ['required', 'multi_space',  'string', 'max:100'],
                        'email'     => ['required', 'string', Rule::unique('customers', 'email')],
                        'role'      => ['required', 'integer'],
                        'password'  => ['required', 'string', 'max:12', 'min:6', 'confirmed'],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'      => ['required', 'multi_space',  'string', 'max:100'],
                        'email'     => ['required', 'string', Rule::unique('customers', 'email')->ignore($this->user->id)],
                        'role'      => ['required', 'integer'],
                        'password'  => ['nullable', 'string', 'max:12', 'min:6', 'confirmed'],
                    ];
                }
            default:
                break;
        }
    }
}
