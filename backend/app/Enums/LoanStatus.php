<?php

namespace App\Enums;

/**
 * @method static LoanStatus DRAFT()
 * @method static LoanStatus CONFIRMED()
 * @method static LoanStatus PARTIAL()
 * @method static LoanStatus PAID()
 */
class LoanStatus extends Enum
{
    private const DRAFT     = 'draft';
    private const CONFIRMED = 'confirmed';
    private const PARTIAL   = 'partial';
    private const PAID      = 'paid';
}
