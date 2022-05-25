<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
                        'zoneId'       => ['required'],
                        'photo'        => ['required', 'image','mimes:jpg,jpeg,png', 'max:2048'],
                        'firstName'    => ['required', 'multi_space', 'string', 'max:100'],
                        'lastName'     => ['required', 'multi_space', 'string', 'max:100'],
                        'email'        => ['nullable', 'string', Rule::unique('employees', 'email')],
                        'phone'        => ['required', 'string', Rule::unique('employees', 'phone')],
                        'status'       => ['required', 'string'],
                        'fatherName'   => ['nullable', 'string', 'max:100'],
                        'motherName'   => ['nullable', 'string', 'max:100'],
                        'gender'       => ['required', 'string'],
                        'maritalStatus'=> ['nullable', 'string'],
                        'bloodGroup'   => ['nullable', 'string'],
                        'designation'  => ['required', 'string', 'max:100'],
                        'joiningDate'  => ['required', 'string'],
                        'resignDate'   => ['nullable', 'string'],
                        'salary'       => ['required', 'numeric','min:0'],

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'zoneId'       => ['required'],
                        'photo'        => ['required', 'image','mimes:jpg,jpeg,png', 'max:2048'],
                        'firstName'    => ['required', 'string', 'multi_space', 'max:100'],
                        'lastName'     => ['required', 'string', 'multi_space', 'max:100'],
                        'email'        => ['nullable', 'string', Rule::unique('employees', 'email')],
                        'phone'        => ['required', 'string', Rule::unique('employees', 'phone')],
                        'status'       => ['required', 'string'],
                        'fatherName'   => ['nullable', 'string', 'max:100'],
                        'motherName'   => ['nullable', 'string', 'max:100'],
                        'gender'       => ['required', 'string'],
                        'maritalStatus'=> ['nullable', 'string'],
                        'bloodGroup'   => ['nullable', 'string'],
                        'designation ' => ['required', 'string', 'max:100'],
                        'joiningDate'  => ['required', 'string'],
                        'resignDate'   => ['nullable', 'string'],
                        'salary '      => ['required', 'numeric','min:0'],
                    ];
                }
            default:
                break;
        }
    }

}
