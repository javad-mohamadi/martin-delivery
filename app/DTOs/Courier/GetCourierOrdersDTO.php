<?php

namespace App\DTOs\Courier;

use Illuminate\Http\Request;

class GetCourierOrdersDTO
{
    public function __construct(public int $courierId)
    {
    }

    public static function getFromRequest(Request $request): GetCourierOrdersDTO
    {
        return new static($request->user()->id);
    }
}
