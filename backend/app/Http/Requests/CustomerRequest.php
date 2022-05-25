<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
                        'photo'        => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                        'firstName'    => ['required', 'string', 'multi_space', 'max:100'],
                        'lastName'     => ['required', 'string', 'multi_space', 'max:100'],
                        'email'        => ['required', 'string', Rule::unique('customers', 'email')],
                        'phone'        => ['required', 'string', Rule::unique('customers', 'phone')],
                        'password'     => ['required', 'string', 'max:12', 'min:6', 'confirmed']
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'photo'        =>  ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                        'firstName'    => ['required', 'string', 'multi_space', 'max:100'],
                        'lastName'     => ['required', 'string', 'multi_space', 'max:100'],
                        'email'        => ['required', 'string', Rule::unique('customers', 'email')->ignore($this->customer->id)],
                        'phone'        => ['required', 'string', Rule::unique('customers', 'phone')->ignore($this->customer->id)],
                    ];
                }
            default:
                break;
        }
    }
}
