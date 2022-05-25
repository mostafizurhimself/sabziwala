<?php

namespace App\Enums;

/**
 * @method static OrderStatus PENDING()
 * @method static OrderStatus PROCESSING()
 * @method static OrderStatus SHIPPED()
 * @method static OrderStatus DELIVERED()
 * @method static OrderStatus CANCELED()
 * @method static OrderStatus REFUNDED()
 */
class OrderStatus extends Enum
{
    private const PENDING    = 'pending';
    private const PROCESSING = 'processing';
    private const SHIPPED    = 'shipped';
    private const DELIVERED  = 'delivered';
    private const CANCELED   = 'canceled';
    private const REFUNDED   = 'refunded';
}