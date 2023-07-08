<?php

namespace App\Services\Processor\Courier;

use App\Models\CourierOrder;
use App\Enum\CourierOrderEnum;
use App\Exceptions\LogicException;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class UpdateStatusToCanceled extends UpdateStatusProcessor
{

    public function process(CourierOrder $courierOrder, string $status)
    {
        if ($courierOrder->status == CourierOrderEnum::STATUS_DELIVERED ||
            $courierOrder->status == CourierOrderEnum::STATUS_EMERGENCY_CANCELED) {
            throw new LogicException(Response::HTTP_BAD_REQUEST);
        }

        return [
            'status'      => $status,
            'canceled_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
