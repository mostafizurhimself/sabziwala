<?php

namespace App\Http\Requests;

use App\Rules\PaidAmountRule;
use Illuminate\Validation\Rule;
use App\Rules\DeductionAmountRule;
use Illuminate\Foundation\Http\FormRequest;

class PayslipRequest extends FormRequest
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
        return [
            'paidAmount'     => ['required', 'numeric', 'min:0', new PaidAmountRule($this->salary->id, request()->get('deductedAmount'))],
            'deductedAmount' => ['required', 'numeric', 'min:0', new DeductionAmountRule($this->salary->id)],
        ];
    }
}
