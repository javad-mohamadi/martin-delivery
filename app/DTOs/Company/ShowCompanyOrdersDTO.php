<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class ShowCompanyOrdersDTO
{
    public $orderId;

    public $companyId;

    public function __construct(int $orderId, int $companyId)
    {
        $this->orderId   = $orderId;
        $this->companyId = $companyId;
    }

    public static function getFromRequest(Request $request): ShowCompanyOrdersDTO
    {
        return new static($request->id, $request->user()->id);
    }
}
