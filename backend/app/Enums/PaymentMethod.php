<?php

namespace App\Enums;

/**
 * @method static PaymentMethod STRIPE()
 * @method static PaymentMethod EASYPAISA()
 * @method static PaymentMethod JAZZCASH()
 * @method static PaymentMethod WALLET()
 * @method static PaymentMethod COD()
 */
class PaymentMethod extends Enum
{
    private const STRIPE    = 'stripe';
    private const EASYPAISA = 'easypaisa';
    private const JAZZCASH  = 'jazzcash';
    private const WALLET    = 'wallet';
    private const COD       = 'cod';
}