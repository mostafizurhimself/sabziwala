<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
                        'expenseTypeId'  => 'required',
                        'description'    => 'required|string|max:250',
                        'amount'         => 'required|numeric|min:00',

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'expenseTypeId'  => 'required',
                        'description'    => 'required|string|max:250',
                        'amount'         => 'required|numeric|min:00',

                    ];
                }
            default:
                break;
        }
    }
}
