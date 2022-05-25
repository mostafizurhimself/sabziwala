<?php

namespace App\Rules;

use App\Models\Salary;
use App\Facades\Helper;
use Akaunting\Money\Money;
use Akaunting\Money\Currency;
use Illuminate\Contracts\Validation\Rule;

class PaidAmountRule implements Rule
{
    /**
     * @var \App\Models\Salary
     */
    public $salary;

    /**
     * @var integer
     */
    public $deductedAmount;

    /**
     * Payable amount
     *
     * @var integer
     */
    public $payable;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($salaryId, $deductedAmount)
    {
        $this->salary = Salary::find($salaryId);
        $this->deductedAmount = $deductedAmount;
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
        $this->payable = $this->salary->totalDue - $this->deductedAmount;
        return $this->payable >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Pay amount can not be greater than ".
        (new Money(ceil($this->payable), new Currency(Helper::getCurrencyCode()), true))->formatWithoutZeroes();
    }
}
