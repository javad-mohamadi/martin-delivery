<?php

namespace App\Enum;

use Illuminate\Validation\Rules\Enum;

class CourierOrderEnum extends Enum
{
    const STATUS_ACCEPTED  = 'accepted';
    const STATUS_RECEIVED  = 'received';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_EMERGENCY_CANCELED = 'emergency_canceled';

    public static function allowStatusForUpdate(): array
    {
        return [
            self::STATUS_RECEIVED,
            self::STATUS_DELIVERED,
            self::STATUS_EMERGENCY_CANCELED,
        ];
    }

}
