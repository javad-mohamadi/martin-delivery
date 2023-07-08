<?php

namespace App\Services\Processor\Courier;

use App\Models\CourierOrder;

abstract class UpdateStatusProcessor
{
    abstract public function process(CourierOrder $courierOrder, string $status);
}
