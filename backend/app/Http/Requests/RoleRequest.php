<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
                        'name'        => ['required', 'string', Rule::unique('roles', 'name')],
                        'description' => ['nullable', 'string', 'max:500'],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'        => ['required', 'string', Rule::unique('roles', 'name')->ignore($this->role->id)],
                        'description' => ['nullable', 'string', 'max:500'],
                    ];
                }
            default:
                break;
        }
    }
}