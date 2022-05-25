<?php

namespace App\Enums;

/**
 * @method static PublishStatus PUBLISHED()
 * @method static PublishStatus UNPUBLISHED()
 */
class RolesType extends Enum
{
    private const SUPERADMIN   = 'Super Admin';
    private const ADMIN = 'Admin';
}
