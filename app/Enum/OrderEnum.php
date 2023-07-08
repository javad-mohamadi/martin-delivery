<?php

namespace App\Enum;

use Illuminate\Validation\Rules\Enum;

class OrderEnum extends Enum
{
    const STATUS_WAITING    = 'waiting_courier';
    const STATUS_EN_ROUTE   = 'courier_en_route';
    const STATUS_IN_TRANSIT = 'courier_in_transit';
    const STATUS_DONE       = 'done';
    const STATUS_CANCELED   = 'canceled';
}
