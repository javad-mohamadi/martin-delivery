<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;

class UpdateCompanyOrderDTO
{
    /**
     * @param int $companyId
     * @param int $orderId
     * @param string|null $status
     */
    public function __construct(
        public int     $companyId,
        public int     $orderId,
        public ?string $status,
        public array   $userCompanyIds,
    )
    {
    }

    /**
     * @param Request $request
     * @return UpdateCompanyOrderDTO
     */
    public static function getFromRequest(Request $request): UpdateCompanyOrderDTO
    {
        $companyIds = [];
        if (!is_null($request->user()->companies)) {
            $companyIds = array_map(function ($item) {
                return $item['id'];
            }, $request->user()->companies->toArray());
        }

        return new static(
            $request->company_id,
            $request->id,
            $request->status,
            $companyIds,
        );
    }
}
