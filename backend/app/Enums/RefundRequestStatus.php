<?php

namespace App\Enums;

/**
 * @method static RefundRequestStatus PENDING()
 * @method static RefundRequestStatus ACCEPTED()
 * @method static RefundRequestStatus DECLINE()
 */
class RefundRequestStatus extends Enum
{
    private const PENDING   = 'pending';
    private const ACCEPTED  = 'accepted';
    private const DECLINED  = 'declined';
}