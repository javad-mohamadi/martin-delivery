<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;

class GetCompanyOrdersDTO
{
    public $companyId;

    public function __construct(int $companyId)
    {
        $this->companyId = $companyId;
    }

    public static function getFromRequest(Request $request)
    {
        return new static($request->user()->id);
    }
}
