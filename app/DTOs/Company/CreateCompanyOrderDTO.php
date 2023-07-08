<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;

class CreateCompanyOrderDTO
{
    /**
     * @param int $companyId
     * @param array $data
     * @param array $userCompanyIds
     */
    public function __construct(
        public int   $companyId,
        public array $data,
        public array $userCompanyIds,
    )
    {
    }

    /**
     * @param Request $request
     * @return CreateCompanyOrderDTO
     */
    public static function getFromRequest(Request $request): CreateCompanyOrderDTO
    {

        $companyIds = [];
        if (!is_null($request->user()->companies)) {
            $companyIds = array_map(function ($item) {
                return $item['id'];
            }, $request->user()->companies->toArray());
        }

        return new static($request->company_id, $request->validated(), $companyIds);
    }
}
