<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;

class ShowCompanyOrderDTO
{
    /**
     * @param int $orderId
     * @param int $companyId
     */
    public function __construct(public int $orderId, public int $companyId)
    {
    }

    /**
     * @param Request $request
     * @return ShowCompanyOrderDTO
     */
    public static function getFromRequest(Request $request): ShowCompanyOrderDTO
    {
        return new static($request->id, $request->company_id);
    }
}
