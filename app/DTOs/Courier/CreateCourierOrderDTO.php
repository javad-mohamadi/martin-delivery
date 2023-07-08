<?php

namespace App\DTOs\Courier;

use Illuminate\Http\Request;

class CreateCourierOrderDTO
{
    public function __construct(public int $orderId,
                                public int $courierId)
    {
    }

    public static function getFromRequest(Request $request): CreateCourierOrderDTO
    {
        return new static($request->order_id, $request->user()->id);
    }
}
