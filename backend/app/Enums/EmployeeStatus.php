<?php

namespace App\Enums;

/**
 * @method static EmployeeStatus INACTIVE()
 * @method static EmployeeStatus ACTIVE()
 * @method static EmployeeStatus RESIGNED()
 */
class EmployeeStatus extends Enum
{
    private const INACTIVE = 'inactive';
    private const ACTIVE   = 'active';
    private const RESIGNED = 'resigned';
}
