<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RiderRequest extends FormRequest
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
                        'zoneId'            => ['required'],
                        'firstName'         => ['required', 'string', 'max:100'],
                        'lastName'          => ['required', 'string', 'max:100'],
                        'email'             => ['required', 'string', Rule::unique('riders', 'email')],
                        'phone'             => ['required', 'string', Rule::unique('riders', 'phone')],
                        'password'          => ['required', 'string', 'max:12', 'min:6', 'confirmed'],
                        'photo'             => ['nullable ', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                        'verificationFront' => ['nullable ', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                        'verificationBack'  => ['nullable ', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'zoneId'        => ['required'],
                        'firstName'         => ['required', 'string', 'max:100'],
                        'lastName'          => ['required', 'string', 'max:100'],
                        'email'             => ['required', 'string', Rule::unique('riders', 'email')->ignore($this->rider->id)],
                        'phone'             => ['required', 'string', Rule::unique('riders', 'phone')->ignore($this->rider->id)],
                        'photo'             => ['nullable ', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                        'verificationFront' => ['nullable ', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                        'verificationBack'  => ['nullable ', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                    ];
                }
            default:
                break;
        }
    }
}
