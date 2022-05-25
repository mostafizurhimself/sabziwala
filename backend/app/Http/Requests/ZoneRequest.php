<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ZoneRequest extends FormRequest
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
                        'name'       => ['required', 'multi_space', 'string', Rule::unique('zones', 'name')->where('country', request()->get('country'))],
                        'city'       => ['required', 'string', 'max:100'],
                        'state'      => ['nullable', 'string', 'max:100'],
                        'zipcode'    => ['required', 'string', 'max:100'],
                        'country'    => ['required', 'string', 'max:100'],

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'      => ['required', 'multi_space', 'string', Rule::unique('zones', 'name')->where('country', request()->get('country'))->ignore($this->zone->id)],
                        'city'       => ['required', 'string', 'max:100'],
                        'state'      => ['nullable', 'string', 'max:100'],
                        'zipcode'    => ['required', 'string', 'max:100'],
                        'country'    => ['required', 'string', 'max:100'],
                    ];
                }
            default:
                break;
        }
    }
}
