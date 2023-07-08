<?php

namespace App\DTOs\Courier;

use Illuminate\Http\Request;

class ShowCourierOrderDTO
{
    public function __construct(public int $courierId, public int $courierOrderId)
    {
    }

    public static function getFromRequest(Request $request): ShowCourierOrderDTO
    {
        return new static($request->user()->id, $request->id);
    }
}
