<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
                        'name'        => ['required', 'multi_space',  'string', Rule::unique('units', 'name')],
                        'code'        => ['required', 'string', 'max:4', 'min:2', Rule::unique('units', 'code')],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'        =>['required', 'multi_space',  'string', Rule::unique('units', 'name')->ignore($this->unit->id)],
                        'code'        =>['required', 'string', 'max:4', 'min:2', Rule::unique('units', 'code')->ignore($this->unit->id)],
                    ];
                }
            default:
                break;
        }
    }
}
