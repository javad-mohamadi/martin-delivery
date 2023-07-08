<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;

class GetCompanyOrdersDTO
{
    /**
     * @param array $companyIds
     */
    public function __construct(public array $companyIds)
    {
    }

    /**
     * @param Request $request
     * @return GetCompanyOrdersDTO
     */
    public static function getFromRequest(Request $request): GetCompanyOrdersDTO
    {
        $companyIds = [];
        if (!is_null($request->user()->companies)) {
            $companyIds = array_map(function ($item) {
                return $item['id'];
            }, $request->user()->companies->toArray());
        }

        return new static($companyIds);
    }
}
