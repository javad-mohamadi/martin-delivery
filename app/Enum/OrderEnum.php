<?php

namespace App\Enum;

use Illuminate\Validation\Rules\Enum;

class OrderEnum extends Enum
{
    const STATUS_PENDING    = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_CANCELED   = 'canceled';
    const STATUS_DONE       = 'done';

    /**
     * @var array|string[]
     */
    public static array $companyAllowCancelOrderStatus = [
        self::STATUS_PENDING,
        self::STATUS_PROCESSING,
    ];
}
