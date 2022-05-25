<?php

namespace App\Http\Requests;

use App\Enums\SalaryStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SalaryRequest extends FormRequest
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
                        'employeeId'    => ['required', 'string', Rule::unique('salaries', 'employee_id')->where('month', request()->get('month'))],
                        'month'         => ['required', 'string'],
                        'totalAmount'   => ['required', 'numeric', 'min:00'],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'employeeId'    => ['required', 'string', Rule::unique('salaries', 'employee_id')->where('month', request()->get('month'))->ignore($this->salary->id)],
                        'month'         => ['required', 'string'],
                        'totalAmount'   => ['required', 'numeric', 'min:00'],
                    ];
                }
            default:
                break;
            }
    }
}
