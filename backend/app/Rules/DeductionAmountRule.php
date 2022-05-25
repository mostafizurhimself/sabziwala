<?php

namespace App\Rules;

use App\Enums\LoanStatus;
use App\Models\Salary;
use Illuminate\Contracts\Validation\Rule;

class DeductionAmountRule implements Rule
{
    /**
     * @var \App\Models\Loan
     */
    public $loan;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($salaryId)
    {
        $this->loan = Salary::find($salaryId)->employee->loans()->whereIn('status', [LoanStatus::CONFIRMED(), LoanStatus::PARTIAL()])->first();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->loan ? $this->loan->dueAmount >= $value : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Deduction amount can be greater than {$this->loan->dueAmount}";
    }
}
