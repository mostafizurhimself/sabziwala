<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
                        'zoneId'        => 'required',
                        'categoryId'    => 'required',
                        'unitId'        => 'required',
                        'name'          => ['required', 'multi_space',  'string', Rule::unique('products', 'name')->where('zone_id', request()->get('zoneId'))],
                        'code'          => ['required', 'string', 'max:30', Rule::unique('products', 'code')],
                        'tags.*'        => 'required|string',
                        'description'   => 'nullable|string|max:500',
                        'actualPrice'   => 'required|numeric|min:00',
                        'salePrice'     => 'required|numeric|min:00',
                        'images'        => 'required',
                        'images.*'      => 'required|image|mimes:jpg,jpeg,png|max:10240',
                        'thumbnail'     => 'required|image|mimes:jpg,jpeg,png|max:5120',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'zoneId'      => 'required',
                        'categoryId'  => 'required',
                        'unitId'      => 'required',
                        'name'        => ['required', 'string', 'multi_space',  Rule::unique('products', 'name')->where('zone_id', request()->get('zoneId'))->ignore($this->product->id)],
                        'code'        => ['required', 'string', 'max:30', Rule::unique('products', 'code')->ignore($this->product->id)],
                        'tags.*'      => 'required|string',
                        'description' => 'nullable|string|max:500',
                        'actualPrice' => 'required|numeric|min:00',
                        'salePrice'   => 'required|numeric|min:00',
                        'images'      => 'nullable',
                        'images.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
                        'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                    ];
                }
            default:
                break;
        }
    }
}
