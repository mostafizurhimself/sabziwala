<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
                        'name'        => ['required', 'string', 'multi_space', Rule::unique('countries', 'name')],
                        'code'        => ['required', 'string', 'max:2', 'min:2', Rule::unique('countries', 'code')],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'        =>['required', 'string', 'multi_space', Rule::unique('countries', 'name')->ignore($this->country->id)],
                        'code'        =>['required', 'string', 'max:2', 'min:2', Rule::unique('countries', 'code')->ignore($this->country->id)],
                    ];
                }
            default:
                break;
        }
    }
}
