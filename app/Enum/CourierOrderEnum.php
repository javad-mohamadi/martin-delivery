<?php

namespace App\Enum;

use Illuminate\Validation\Rules\Enum;

class CourierOrderEnum extends Enum
{
    const STATUS_ACCEPTED  = 'accepted';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_RECEIVED  = 'received';
    const STATUS_CANCELED  = 'canceled';

}
