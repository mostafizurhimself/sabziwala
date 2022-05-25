<?php

namespace App\Enums;

/**
 * @method static SalaryType EMPLOYEE()
 * @method static SalaryType RIDER()
 */
class SalaryType extends Enum
{
    private const EMPLOYEE     = 'employee';
    private const RIDER        = 'rider';
}
