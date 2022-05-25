<?php

namespace App\Enums;

/**
 * @method static SalaryStatus DRAFT()
 * @method static SalaryStatus CONFIRMED()
 * @method static SalaryStatus PARTIAL()
 * @method static SalaryStatus PAID()
 */
class SalaryStatus extends Enum
{
    private const DRAFT     = 'draft';
    private const CONFIRMED = 'confirmed';
    private const PARTIAL   = 'partial';
    private const PAID      = 'paid';
}
