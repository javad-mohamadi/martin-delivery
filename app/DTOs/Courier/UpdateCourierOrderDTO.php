<?php

namespace App\DTOs\Courier;

use Illuminate\Http\Request;

class UpdateCourierOrderDTO
{
    /**
     * @param int $courierId
     * @param int $courierOrderId
     * @param string|null $status
     */
    public function __construct(public int $courierId, public int $courierOrderId, public ?string $status)
    {
    }

    /**
     * @param Request $request
     * @return UpdateCourierOrderDTO
     */
    public static function getFromRequest(Request $request): UpdateCourierOrderDTO
    {
        return new static(
            $request->user()->id,
            $request->id,
            $request->status,
        );
    }
}
