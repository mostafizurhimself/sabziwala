<?php

namespace App\Http\Requests;

use App\Enums\LoanStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
                        'employeeId'    => ['required', 'integer', Rule::unique('loans', 'employee_id')->whereNot('status', LoanStatus::PAID())],
                        'loanDate'      => ['required', 'string'],
                        'loanAmount'    => ['required', 'numeric', 'min:00'],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'employeeId'    => ['required', 'integer', Rule::unique('loans', 'employee_id')->whereNot('status', LoanStatus::PAID())->ignore($this->loan->id)],
                        'loanDate'      => ['required', 'string'],
                        'loanAmount'    => ['required', 'numeric', 'min:00'],
                    ];
                }
            default:
                break;
        }

    }

    /**
     * Customer validation messages
     */
    public function messages()
    {
        return [
            'employeeId.unique' => "This employee already has loan.",
        ];
    }
}
