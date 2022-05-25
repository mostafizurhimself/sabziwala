<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                        'name'        => ['required', 'string', 'multi_space', Rule::unique('categories', 'name')],
                        'description' => 'nullable|string|max:500',
                        'image'       => 'required|image|mimes:jpg,jpeg,png|max:5120',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'        =>['required', 'string', 'multi_space', Rule::unique('categories', 'name')->ignore($this->category->id)],
                        'description' => 'nullable|string|max:500',
                        'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                    ];
                }
            default:
                break;
        }
    }
}
