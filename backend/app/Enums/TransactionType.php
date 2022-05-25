<?php

namespace App\Enums;

/**
 * @method static TransactionType DEBIT()
 * @method static TransactionType CREDIT()
 */
class TransactionType extends Enum
{
    private const DEBIT  = 'debit';
    private const CREDIT = 'credit';
}